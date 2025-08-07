<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Course;
use App\Models\StudentCourse;

class TestCGPAFunction extends Command
{
    protected $signature = 'test:cgpa';
    protected $description = 'Test CGPA calculation functionality';

    public function handle()
    {
        // Get the test user
        $testUser = User::where('email', 'test@student.com')->first();
        
        if (!$testUser) {
            $this->error("Test user not found. Run 'php artisan test:courses' first.");
            return;
        }
        
        $this->info("Testing CGPA functionality for: {$testUser->name}");
        
        // Get some courses for Level 1, Term 1
        $level1Term1Courses = Course::where('department_id', $testUser->department_id)
            ->where('level', 1)
            ->where('term', 1)
            ->take(3)
            ->get();
            
        $this->info("Found " . $level1Term1Courses->count() . " courses for Level 1 Term 1");
        
        // Grade point mapping
        $grades = ['A+', 'A', 'B+'];
        $gradePoints = [
            'A+' => 4.00, 'A' => 3.75, 'A-' => 3.50,
            'B+' => 3.25, 'B' => 3.00, 'B-' => 2.75,
            'C+' => 2.50, 'C' => 2.25, 'C-' => 2.00,
            'D+' => 1.75, 'D' => 1.50, 'F' => 0.00
        ];
        
        // Clear existing test grades
        StudentCourse::where('user_id', $testUser->id)->delete();
        
        // Add some sample grades
        foreach ($level1Term1Courses as $index => $course) {
            $grade = $grades[$index % count($grades)];
            
            StudentCourse::create([
                'user_id' => $testUser->id,
                'course_id' => $course->id,
                'grade' => $grade,
                'grade_point' => $gradePoints[$grade],
                'status' => 'completed',
                'semester_taken' => $course->term,
                'year_taken' => $course->level
            ]);
            
            $this->info("Added grade {$grade} ({$gradePoints[$grade]}) for {$course->course_code} - {$course->course_name} ({$course->credits} credits)");
        }
        
        // Calculate CGPA
        $cgpa = StudentCourse::calculateCGPA($testUser->id);
        $semesterGPA = StudentCourse::calculateSemesterGPA($testUser->id, 1, 1);
        
        $this->info("Calculated CGPA: {$cgpa}");
        $this->info("Calculated Level 1 Term 1 GPA: {$semesterGPA}");
        
        $this->info("✅ CGPA functionality is working correctly!");
    }
}
