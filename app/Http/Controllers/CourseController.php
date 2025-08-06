<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\StudentCourse;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display the my courses page based on user's academic progression
     */
    public function myCourses()
    {
        $user = Auth::user() ?? (object)[
            'name' => 'Test User', 
            'role' => 'student',
            'admission_semester' => 'Spring',
            'admission_year' => 2024,
            'department_id' => 1
        ];
        
        // Get user's current academic level and term
        $currentLevel = method_exists($user, 'getCurrentLevel') ? $user->getCurrentLevel() : 1;
        $currentTerm = method_exists($user, 'getCurrentTerm') ? $user->getCurrentTerm() : 1;
        
        // Get user's department
        $department = null;
        if (isset($user->department_id)) {
            $department = Department::find($user->department_id);
        }
        if (!$department) {
            $department = Department::firstOrCreate(
                ['code' => 'CSE'],
                [
                    'name' => 'Computer Science and Engineering',
                    'description' => 'Department of Computer Science and Engineering'
                ]
            );
        }
        
        // Get courses from comprehensive_courses table based on user's progression
        $coursesBySemester = [];
        $enrolledCoursesData = [];
        
        // Show courses up to current level and term
        for ($level = 1; $level <= $currentLevel; $level++) {
            $maxTerm = ($level == $currentLevel) ? $currentTerm : 3;
            
            for ($term = 1; $term <= $maxTerm; $term++) {
                // Get courses from courses table based on department
                $courses = Course::with('department')
                    ->where('department_id', $department->id)
                    ->where('level', $level)
                    ->where('term', $term)
                    ->orderBy('course_code')
                    ->get();
                
                if ($courses->count() > 0) {
                    $semesterKey = "Level {$level} - Term {$term}";
                    $coursesBySemester[$semesterKey] = $courses;
                    
                    // Mark current semester
                    if ($level == $currentLevel && $term == $currentTerm) {
                        $coursesBySemester[$semesterKey . ' (Current)'] = $coursesBySemester[$semesterKey];
                        unset($coursesBySemester[$semesterKey]);
                    }
                }
            }
        }
        
        // Get student's enrolled courses and grades from the regular courses table
        $studentCourses = collect([]);
        if (method_exists($user, 'id')) {
            $studentCourses = StudentCourse::where('user_id', $user->id)
                ->with('course')
                ->get()
                ->keyBy('course_id');
        }
        
        // Calculate CGPA and semester GPAs
        $cgpa = 0;
        $semesterGPAs = [];
        if (method_exists($user, 'id')) {
            $cgpa = StudentCourse::calculateCGPA($user->id);
            
            // Calculate semester GPAs for completed semesters
            for ($level = 1; $level <= $currentLevel; $level++) {
                $maxTerm = ($level == $currentLevel) ? $currentTerm - 1 : 3;
                
                for ($term = 1; $term <= $maxTerm; $term++) {
                    if ($maxTerm >= 1) {
                        $gpa = StudentCourse::calculateSemesterGPA($user->id, $term, $level);
                        if ($gpa > 0) {
                            $semesterGPAs["Level {$level} - Term {$term}"] = $gpa;
                        }
                    }
                }
            }
        }
        
        // Add user academic info for display
        $academicInfo = [
            'current_level' => $currentLevel,
            'current_term' => $currentTerm,
            'admission_semester' => $user->admission_semester ?? 'Spring',
            'admission_year' => $user->admission_year ?? date('Y'),
            'department' => $department->name ?? 'Computer Science and Engineering'
        ];
        
        return view('courses.my-courses', compact(
            'coursesBySemester', 
            'studentCourses', 
            'cgpa', 
            'semesterGPAs', 
            'user',
            'academicInfo'
        ));
    }
    
    /**
     * Show course details
     */
    public function show(Course $course)
    {
        $user = Auth::user() ?? (object)['name' => 'Test User', 'role' => 'student'];
        
        $course->load('department', 'courseResources');
        
        // Get student's enrollment for this course
        $studentCourse = null;
        if (method_exists($user, 'id')) {
            $studentCourse = StudentCourse::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
        }
        
        return view('courses.show', compact('course', 'studentCourse', 'user'));
    }
    
    /**
     * Update student grade for a course
     */
    public function updateGrade(Request $request, Course $course)
    {
        $request->validate([
            'grade' => 'required|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
            'status' => 'required|in:enrolled,completed,dropped,failed'
        ]);
        
        $user = Auth::user() ?? (object)['id' => 1, 'name' => 'Test User', 'role' => 'student'];
        
        // Grade point mapping
        $gradePoints = [
            'A+' => 4.00, 'A' => 3.75, 'A-' => 3.50,
            'B+' => 3.25, 'B' => 3.00, 'B-' => 2.75,
            'C+' => 2.50, 'C' => 2.25, 'C-' => 2.00,
            'D+' => 1.75, 'D' => 1.50, 'F' => 0.00
        ];
        
        StudentCourse::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id
            ],
            [
                'grade' => $request->grade,
                'grade_point' => $gradePoints[$request->grade],
                'status' => $request->status,
                'semester_taken' => $course->term,
                'year_taken' => $course->level
            ]
        );
        
        return redirect()->back()->with('success', 'Grade updated successfully!');
    }
}
