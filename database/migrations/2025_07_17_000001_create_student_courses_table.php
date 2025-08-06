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
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['enrolled', 'completed', 'dropped', 'failed'])->default('enrolled');
            $table->string('grade')->nullable(); // A+, A, A-, B+, B, B-, C+, C, C-, D+, D, F
            $table->decimal('grade_point', 3, 2)->nullable(); // 4.00, 3.67, 3.33, etc.
            $table->integer('semester_taken'); // Which semester they took this course
            $table->integer('year_taken'); // Which year they took this course
            $table->timestamps();
            
            // Unique constraint to prevent duplicate enrollments
            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_courses');
    }
};
