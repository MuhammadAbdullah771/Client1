<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DbVerifyCommand extends Command
{
    protected $signature = 'db:verify {--migrate : Run migrations first}';

    protected $description = 'Verify database connection, run migrations if requested, and list tables.';

    public function handle(): int
    {
        $this->info('Database verification');
        $this->newLine();

        $driver = config('database.default');
        $this->line('Connection: <comment>' . $driver . '</comment>');

        try {
            DB::connection()->getPdo();
            $this->info('Connection OK.');
        } catch (\Throwable $e) {
            $this->error('Connection failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        if ($this->option('migrate')) {
            $this->call('migrate', ['--force' => true]);
        }

        $raw = Schema::getTables();
        $tables = collect($raw)->pluck('name')->filter()->values()->all();
        if (empty($tables)) {
            $this->warn('No tables found. Run: php artisan migrate');
            return self::SUCCESS;
        }

        $this->newLine();
        $this->info('Tables (' . count($tables) . '):');
        foreach ($tables as $t) {
            $this->line('  - ' . $t);
        }

        return self::SUCCESS;
    }
}
