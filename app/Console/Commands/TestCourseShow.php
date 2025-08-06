<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;
use App\Models\User;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Auth;

class TestCourseShow extends Command
{
    protected $signature = 'test:course-show';
    protected $description = 'Test course show functionality';

    public function handle()
    {
        // Get a test course
        $course = Course::first();
        if (!$course) {
            $this->error("No courses found in database");
            return;
        }
        
        $this->info("Testing course show for: {$course->course_code} - {$course->course_name}");
        
        // Get test user
        $testUser = User::where('email', 'test@student.com')->first();
        if ($testUser) {
            Auth::login($testUser);
            $this->info("Logged in as: {$testUser->name}");
        }
        
        // Test the controller method
        $controller = new CourseController();
        
        try {
            $response = $controller->show($course);
            
            if ($response instanceof \Illuminate\View\View) {
                $this->info("✅ Controller returns a view");
                $this->info("View name: " . $response->getName());
                $viewData = $response->getData();
                $this->info("View data keys: " . implode(', ', array_keys($viewData)));
                
                if (isset($viewData['course'])) {
                    $courseData = $viewData['course'];
                    $this->info("Course in view: {$courseData->course_code} - {$courseData->course_name}");
                }
            } else {
                $this->error("❌ Controller does not return a view");
                $this->error("Response type: " . get_class($response));
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error in course show: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
        
        // Check if the route exists and is accessible
        $this->info("Course show route URL: " . route('courses.show', $course));
    }
}
