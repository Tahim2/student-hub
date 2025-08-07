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
        Schema::create('comprehensive_courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Course code like CSE-101, MAT-101
            $table->string('title'); // Course title
            $table->enum('type', ['core', 'lab', 'elective', 'project', 'internship']); // Course type
            $table->decimal('credits', 3, 1); // Credits (allows 1.5, 3.0, etc.)
            $table->integer('level'); // Academic level (1, 2, 3, 4)
            $table->integer('term'); // Term within level (1, 2, 3)
            $table->string('department')->default('CSE'); // Department
            $table->text('description')->nullable(); // Course description
            $table->boolean('is_elective')->default(false); // Is this an elective course
            $table->string('elective_type')->nullable(); // Type of elective (I, II, III, etc.)
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['level', 'term']);
            $table->index(['department']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprehensive_courses');
    }
};
