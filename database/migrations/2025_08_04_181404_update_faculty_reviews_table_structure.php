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
        // Drop and recreate the table with correct structure
        Schema::dropIfExists('faculty_reviews');
        
        Schema::create('faculty_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('users')->onDelete('cascade'); // Reference users table for faculty
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            
            // Detailed rating fields
            $table->integer('overall_rating'); // 1-5 stars
            $table->integer('teaching_quality'); // 1-5 stars
            $table->integer('communication'); // 1-5 stars
            $table->integer('course_organization'); // 1-5 stars
            $table->integer('helpfulness'); // 1-5 stars
            $table->integer('fairness'); // 1-5 stars
            
            $table->text('review_text')->nullable();
            $table->string('semester')->nullable(); // e.g., "Fall 2024"
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_flagged')->default(false);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            // Ensure a user can only review a faculty member once per course
            $table->unique(['user_id', 'faculty_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original table structure
        Schema::dropIfExists('faculty_reviews');
        
        Schema::create('faculty_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('faculty_id')->constrained('faculty_profiles')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1-5 stars
            $table->text('review_text')->nullable();
            $table->string('semester')->nullable(); // e.g., "Fall 2024"
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_flagged')->default(false);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'faculty_id', 'course_id']);
        });
    }
};
