<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('file_path'); // Original file path/name
            $table->string('file_url'); // Public accessible URL
            $table->string('file_type'); // image, video, document, etc.
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable(); // in bytes
            $table->string('alt_text')->nullable(); // For images
            $table->string('category')->nullable(); // hero, service, portfolio, blog, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('category');
            $table->index('file_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
