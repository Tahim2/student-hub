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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['file', 'link']);
            $table->string('file_path')->nullable(); // For uploaded files
            $table->string('google_drive_id')->nullable(); // Google Drive file ID
            $table->string('external_url')->nullable(); // For external links
            $table->string('file_type')->nullable(); // pdf, doc, ppt, etc.
            $table->bigInteger('file_size')->nullable(); // in bytes
            $table->json('tags')->nullable(); // Array of tags
            $table->integer('download_count')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            $table->index(['course_id', 'is_approved']);
            $table->index(['type', 'is_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
