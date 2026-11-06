<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

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
        $addColumnSafely = function($table, $column, $definition) use ($columnExists) {
            if ($columnExists($table, $column)) {
                echo "  Column '{$column}' already exists in '{$table}' table, skipping...\n";
                return false;
            }
            
            try {
                DB::statement("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
                echo "  ✓ Added column '{$column}' to '{$table}' table\n";
                return true;
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();
                // Check if it's a duplicate column error
                if (strpos($errorMsg, 'Duplicate column') !== false || 
                    strpos($errorMsg, '1060') !== false ||
                    strpos($errorMsg, 'already exists') !== false) {
                    echo "  Column '{$column}' already exists (caught during add), skipping...\n";
                    return false;
                } else {
                    echo "  ✗ Failed to add '{$column}' to '{$table}': {$errorMsg}\n";
                    throw $e;
                }
            }
        };

        echo "Fixing missing database columns...\n\n";

        // 1. Services Table - Contact fields
        echo "1. Checking Services table (contact fields)...\n";
        $addColumnSafely('services', 'contact_email', 'VARCHAR(255) NULL');
        $addColumnSafely('services', 'contact_message', 'TEXT NULL');
        
        // 2. Services Table - Structured content fields
        echo "\n2. Checking Services table (structured content)...\n";
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

        // 3. Leaders Table
        echo "\n3. Checking Leaders table...\n";
        $addColumnSafely('leaders', 'department', 'VARCHAR(255) NULL');

        // 4. Milestones Table
        echo "\n4. Checking Milestones table...\n";
        if (Schema::hasTable('milestones')) {
            $addColumnSafely('milestones', 'position', "ENUM('left', 'right') DEFAULT 'left'");
        } else {
            echo "  Milestones table does not exist, skipping...\n";
        }

        // 5. Insights Table
        echo "\n5. Checking Insights table...\n";
        $addColumnSafely('insights', 'heading', 'VARCHAR(255) NULL');

        echo "\n✓ Database column fix completed!\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is safe to run multiple times, so we don't need a down method
        // or we can leave it empty since we're only adding missing columns
    }
};

