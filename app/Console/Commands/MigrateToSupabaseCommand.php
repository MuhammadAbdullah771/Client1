<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateToSupabaseCommand extends Command
{
    protected $signature = 'db:migrate-to-supabase
                            {--fresh : Truncate target tables before copying data}
                            {--tables= : Comma-separated table list (default: all source tables)}';

    protected $description = 'Copy data from legacy MySQL (mysql_source) into the active database (Supabase/PostgreSQL).';

    /** @var list<string> */
    private array $skipTables = [
        'migrations',
    ];

    public function handle(): int
    {
        $target = config('database.default');
        $targetDriver = config("database.connections.{$target}.driver");

        if ($targetDriver !== 'pgsql') {
            $this->error('Target connection must be PostgreSQL (Supabase). Set DB_CONNECTION=pgsql in .env.');
            return self::FAILURE;
        }

        try {
            DB::connection('mysql_source')->getPdo();
            $this->info('MySQL source connection OK.');
        } catch (\Throwable $e) {
            $this->error('MySQL source connection failed: '.$e->getMessage());
            $this->line('Set MYSQL_SOURCE_HOST, MYSQL_SOURCE_DATABASE, MYSQL_SOURCE_USERNAME, MYSQL_SOURCE_PASSWORD in .env');
            return self::FAILURE;
        }

        try {
            DB::connection()->getPdo();
            $this->info('Supabase target connection OK.');
        } catch (\Throwable $e) {
            $this->error('Supabase target connection failed: '.$e->getMessage());
            return self::FAILURE;
        }

        if (! $this->confirm('Run migrations on Supabase target first?', true)) {
            $this->warn('Skipping migrate. Ensure target schema is up to date.');
        } else {
            $this->call('migrate', ['--force' => true]);
        }

        $tables = $this->resolveTables();

        if ($tables === []) {
            $this->error('No tables found on MySQL source.');
            return self::FAILURE;
        }

        if ($this->option('fresh') && ! $this->confirm('This will DELETE data in target tables. Continue?', false)) {
            $this->warn('Aborted.');
            return self::FAILURE;
        }

        if ($this->option('fresh')) {
            $this->truncateTargetTables($tables);
        }

        $this->newLine();
        $this->info('Copying '.count($tables).' table(s) from MySQL → Supabase...');

        foreach ($tables as $table) {
            $this->copyTable($table);
        }

        $this->syncAdminsFromUsers();

        $this->resetPostgresSequences($tables);
        $this->newLine();
        $this->info('Data migration completed.');

        return self::SUCCESS;
    }

    /** @return list<string> */
    private function resolveTables(): array
    {
        $requested = $this->option('tables');

        if (is_string($requested) && $requested !== '') {
            return array_values(array_filter(array_map('trim', explode(',', $requested))));
        }

        $raw = Schema::connection('mysql_source')->getTables();

        return collect($raw)
            ->pluck('name')
            ->filter()
            ->reject(fn (string $name) => in_array($name, $this->skipTables, true))
            ->values()
            ->all();
    }

    private function copyTable(string $table): void
    {
        if (! Schema::connection('mysql_source')->hasTable($table)) {
            $this->warn("  Skip {$table} (not on source)");
            return;
        }

        if (! Schema::hasTable($table)) {
            $this->warn("  Skip {$table} (not on target — run migrations)");
            return;
        }

        $total = (int) DB::connection('mysql_source')->table($table)->count();

        if ($total === 0) {
            $this->line("  {$table}: empty");
            return;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->setFormat("  {$table}: %current%/%max% [%bar%] %percent:3s%%");
        $bar->start();

        $orderColumn = Schema::connection('mysql_source')->hasColumn($table, 'id') ? 'id' : null;
        $query = DB::connection('mysql_source')->table($table);
        if ($orderColumn) {
            $query->orderBy($orderColumn);
        }

        $query->chunk(200, function ($rows) use ($table, $bar) {
            $payload = [];

            foreach ($rows as $row) {
                $payload[] = (array) $row;
                $bar->advance();
            }

            if ($payload !== []) {
                DB::table($table)->insert($payload);
            }
        });

        $bar->finish();
        $this->newLine();
    }

    /** @param  list<string>  $tables */
    private function resetPostgresSequences(array $tables): void
    {
        $this->newLine();
        $this->info('Resetting PostgreSQL sequences...');

        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $pk = $this->primaryKeyColumn($table);

            if ($pk === null) {
                continue;
            }

            try {
                DB::statement(
                    "SELECT setval(pg_get_serial_sequence('{$table}', '{$pk}'), COALESCE((SELECT MAX({$pk}) FROM {$table}), 1))"
                );
                $this->line("  {$table}.{$pk}");
            } catch (\Throwable) {
                $this->warn("  Could not reset sequence for {$table} (may not use serial PK)");
            }
        }
    }

    /** @param  list<string>  $tables */
    private function truncateTargetTables(array $tables): void
    {
        $this->warn('Truncating target tables...');
        DB::statement('SET session_replication_role = replica');

        foreach (array_reverse($tables) as $table) {
            if (Schema::hasTable($table)) {
                DB::statement('TRUNCATE TABLE "'.$table.'" RESTART IDENTITY CASCADE');
            }
        }

        DB::statement('SET session_replication_role = DEFAULT');
    }

    private function syncAdminsFromUsers(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasTable('admins')) {
            return;
        }

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('admins')->updateOrInsert(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'password' => $user->password,
                    'created_at' => $user->created_at ?? now(),
                    'updated_at' => $user->updated_at ?? now(),
                ]
            );
        }

        $this->info('Synced admin accounts from users table.');
    }

    private function primaryKeyColumn(string $table): ?string
    {
        $columns = Schema::getColumns($table);

        foreach ($columns as $column) {
            if (($column['auto_increment'] ?? false) || ($column['name'] ?? '') === 'id') {
                return $column['name'];
            }
        }

        return 'id';
    }
}
