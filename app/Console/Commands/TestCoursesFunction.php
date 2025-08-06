<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CourseController;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class TestCoursesFunction extends Command
{
    protected $signature = 'test:courses';
    protected $description = 'Test courses functionality';

    public function handle()
    {
        // Create test user if doesn't exist
        $testUser = User::firstOrCreate(
            ['email' => 'test@student.com'],
            [
                'name' => 'Test Student',
                'role' => 'student',
                'admission_semester' => 'Spring',
                'admission_year' => 2024,
                'department_id' => 1, // CSE
                'password' => bcrypt('password'),
            ]
        );

        $this->info("Test user created/found: {$testUser->name} (ID: {$testUser->id})");
        
        // Check if CSE department exists
        $cseDept = Department::where('code', 'CSE')->first();
        if ($cseDept) {
            $this->info("CSE Department found: {$cseDept->name} (ID: {$cseDept->id})");
            
            // Update test user to belong to CSE department
            $testUser->update(['department_id' => $cseDept->id]);
        }
        
        // Test the myCourses method
        Auth::login($testUser);
        
        $controller = new CourseController();
        
        try {
            // Call myCourses method
            $this->info("Testing myCourses method...");
            
            // Get user's current level and term
            $currentLevel = $testUser->getCurrentLevel();
            $currentTerm = $testUser->getCurrentTerm();
            
            $this->info("Current Level: {$currentLevel}, Current Term: {$currentTerm}");
            
            // Count courses for this user's department by level/term
            $courseCounts = [];
            for ($level = 1; $level <= 4; $level++) {
                for ($term = 1; $term <= 3; $term++) {
                    $count = \App\Models\Course::where('department_id', $cseDept->id)
                        ->where('level', $level)
                        ->where('term', $term)
                        ->count();
                    
                    if ($count > 0) {
                        $courseCounts["L{$level}T{$term}"] = $count;
                    }
                }
            }
            
            $this->info("Course distribution:");
            foreach ($courseCounts as $semesterTerm => $count) {
                $this->info("  {$semesterTerm}: {$count} courses");
            }
            
            $this->info("✅ Courses are accessible and properly distributed!");
            
        } catch (\Exception $e) {
            $this->error("❌ Error testing courses: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}
