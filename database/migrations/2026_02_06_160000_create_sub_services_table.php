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
        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('heading_1')->nullable();
            $table->text('content_1')->nullable();
            $table->string('heading_2')->nullable();
            $table->text('content_2')->nullable();
            $table->string('heading_3')->nullable();
            $table->text('content_3')->nullable();
            $table->string('heading_4')->nullable();
            $table->text('content_4')->nullable();
            $table->string('heading_5')->nullable();
            $table->text('content_5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_services');
    }
};

