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
        Schema::create('faculty_course_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('semester'); // e.g., "Spring 2025", "Fall 2024"
            $table->year('academic_year'); // e.g., 2025
            $table->enum('semester_type', ['Spring', 'Summer', 'Fall']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Ensure a faculty member can't be assigned to the same course multiple times in the same semester
            $table->unique(['faculty_id', 'course_id', 'semester', 'academic_year'], 'faculty_course_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_course_assignments');
    }
};
