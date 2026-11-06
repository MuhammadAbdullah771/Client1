<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixDatabaseColumns extends Command
{
    protected $signature = 'db:fix-columns';

    protected $description = 'Automatically add missing database columns safely (checks if they exist first)';

    public function handle(): int
    {
        $this->info('========================================');
        $this->info('Database Column Fix Script');
        $this->info('========================================');
        $this->newLine();

        $fixes = [];
        $errors = [];
        $skipped = [];

        // Helper function to check if column exists
        $columnExists = function($table, $column) {
            try {
                $columns = Schema::getColumnListing($table);
                return in_array($column, $columns);
            } catch (\Exception $e) {
                return false;
            }
        };

        // Helper function to add column safely
        $addColumnSafely = function($table, $column, $definition) use ($columnExists, &$fixes, &$errors, &$skipped) {
            if ($columnExists($table, $column)) {
                $this->line("  ✓ Column '{$column}' already exists in '{$table}' table");
                $skipped[] = "Column '{$column}' already exists in '{$table}'";
                return false;
            }
            
            try {
                DB::statement("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
                $this->info("  ✓ Added column '{$column}' to '{$table}' table");
                $fixes[] = "Added '{$column}' to '{$table}' table";
                return true;
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();
                // Check if it's a duplicate column error
                if (strpos($errorMsg, 'Duplicate column') !== false || 
                    strpos($errorMsg, '1060') !== false ||
                    strpos($errorMsg, 'already exists') !== false) {
                    $this->warn("  ⚠ Column '{$column}' already exists (caught during add)");
                    $skipped[] = "Column '{$column}' already exists in '{$table}' (caught during add)";
                    return false;
                } else {
                    $this->error("  ✗ Failed to add '{$column}' to '{$table}': {$errorMsg}");
                    $errors[] = "Failed to add '{$column}' to '{$table}': {$errorMsg}";
                    return false;
                }
            }
        };

        // 1. Fix Services Table
        $this->info('1. Checking Services table...');
        try {
            // Contact fields
            $addColumnSafely('services', 'contact_email', 'VARCHAR(255) NULL');
            $addColumnSafely('services', 'contact_message', 'TEXT NULL');
            
            // Structured content fields
            $addColumnSafely('services', 'intro_text', 'TEXT NULL');
            $addColumnSafely('services', 'main_heading', 'VARCHAR(255) NULL');
            $addColumnSafely('services', 'content_paragraph_1', 'TEXT NULL');
            $addColumnSafely('services', 'content_paragraph_2', 'TEXT NULL');
            $addColumnSafely('services', 'services_list', 'TEXT NULL');
            $addColumnSafely('services', 'additional_info_title', 'VARCHAR(255) NULL');
            $addColumnSafely('services', 'additional_info_content', 'TEXT NULL');
            $addColumnSafely('services', 'additional_info_link', 'VARCHAR(500) NULL');
            $addColumnSafely('services', 'section_title', 'VARCHAR(255) NULL');
            $addColumnSafely('services', 'section_content_1', 'TEXT NULL');
            $addColumnSafely('services', 'section_content_2', 'TEXT NULL');
            $addColumnSafely('services', 'section_content_3', 'TEXT NULL');
            $addColumnSafely('services', 'contact_cta_text', 'VARCHAR(500) NULL');
            $addColumnSafely('services', 'contact_cta_link', 'VARCHAR(500) NULL');
            
            $this->info('  ✓ Services table check completed');
            $this->newLine();
        } catch (\Exception $e) {
            $errors[] = "Services table check failed: " . $e->getMessage();
            $this->error('  ✗ ERROR: ' . $e->getMessage());
            $this->newLine();
        }

        // 2. Fix Leaders Table
        $this->info('2. Checking Leaders table...');
        try {
            $addColumnSafely('leaders', 'department', 'VARCHAR(255) NULL');
            $this->info('  ✓ Leaders table check completed');
            $this->newLine();
        } catch (\Exception $e) {
            $errors[] = "Leaders table check failed: " . $e->getMessage();
            $this->error('  ✗ ERROR: ' . $e->getMessage());
            $this->newLine();
        }

        // 3. Fix Milestones Table
        $this->info('3. Checking Milestones table...');
        try {
            if (!Schema::hasTable('milestones')) {
                $this->warn('  ⚠ Milestones table does not exist, skipping');
                $skipped[] = "Milestones table does not exist";
            } else {
                $addColumnSafely('milestones', 'position', "ENUM('left', 'right') DEFAULT 'left'");
            }
            $this->info('  ✓ Milestones table check completed');
            $this->newLine();
        } catch (\Exception $e) {
            $errors[] = "Milestones table check failed: " . $e->getMessage();
            $this->error('  ✗ ERROR: ' . $e->getMessage());
            $this->newLine();
        }

        // 4. Fix Insights Table
        $this->info('4. Checking Insights table...');
        try {
            $addColumnSafely('insights', 'heading', 'VARCHAR(255) NULL');
            $this->info('  ✓ Insights table check completed');
            $this->newLine();
        } catch (\Exception $e) {
            $errors[] = "Insights table check failed: " . $e->getMessage();
            $this->error('  ✗ ERROR: ' . $e->getMessage());
            $this->newLine();
        }

        // Summary
        $this->info('========================================');
        $this->info('Summary');
        $this->info('========================================');
        $this->info('✓ Columns added: ' . count($fixes));
        $this->warn('⚠ Columns skipped (already exist): ' . count($skipped));
        $this->error('✗ Errors: ' . count($errors));
        $this->newLine();

        if (count($fixes) > 0) {
            $this->info('Added columns:');
            foreach ($fixes as $fix) {
                $this->line('  - ' . $fix);
            }
            $this->newLine();
        }

        if (count($errors) > 0) {
            $this->error('Errors encountered:');
            foreach ($errors as $error) {
                $this->line('  ✗ ' . $error);
            }
            $this->newLine();
        }

        if (count($fixes) > 0) {
            $this->info('Please clear Laravel caches:');
            $this->line('  php artisan config:clear');
            $this->line('  php artisan cache:clear');
            $this->line('  php artisan route:clear');
            $this->line('  php artisan view:clear');
            $this->newLine();
        }

        $this->info('Script completed!');

        return count($errors) > 0 ? self::FAILURE : self::SUCCESS;
    }
}

