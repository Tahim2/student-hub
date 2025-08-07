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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->text('description')->nullable();
            $table->decimal('credits', 3, 1); // Changed to decimal for 1.5 credits
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->enum('course_type', ['Core Theory', 'Core Lab', 'GED Theory', 'GED Lab', 'Project', 'Elective']);
            $table->integer('level'); // 1, 2, 3, 4 (Year/Level)
            $table->integer('term'); // 1, 2, 3 (Term/Semester)
            $table->string('prerequisites')->nullable(); // Comma-separated course codes
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
