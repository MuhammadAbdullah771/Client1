<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->text('intro_text')->nullable()->after('description');
            $table->string('main_heading')->nullable()->after('intro_text');
            $table->text('content_paragraph_1')->nullable()->after('main_heading');
            $table->text('content_paragraph_2')->nullable()->after('content_paragraph_1');
            $table->text('services_list')->nullable()->after('content_paragraph_2'); // JSON array of service items
            $table->string('additional_info_title')->nullable()->after('services_list');
            $table->text('additional_info_content')->nullable()->after('additional_info_title');
            $table->string('additional_info_link')->nullable()->after('additional_info_content');
            $table->string('section_title')->nullable()->after('additional_info_link'); // e.g., "Personal service"
            $table->text('section_content_1')->nullable()->after('section_title');
            $table->text('section_content_2')->nullable()->after('section_content_1');
            $table->text('section_content_3')->nullable()->after('section_content_2');
            $table->string('contact_cta_text')->nullable()->after('section_content_3');
            $table->string('contact_cta_link')->nullable()->after('contact_cta_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'intro_text',
                'main_heading',
                'content_paragraph_1',
                'content_paragraph_2',
                'services_list',
                'additional_info_title',
                'additional_info_content',
                'additional_info_link',
                'section_title',
                'section_content_1',
                'section_content_2',
                'section_content_3',
                'contact_cta_text',
                'contact_cta_link',
            ]);
        });
    }
};
