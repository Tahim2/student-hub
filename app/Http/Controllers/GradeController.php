<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentCourse;
use App\Models\Course;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display the CGPA Tracker page
     */
    public function index(Request $request)
    {
        $user = Auth::user() ?? (object)[
            'id' => 1, 
            'name' => 'Test User', 
            'role' => 'student', 
            'department_id' => 1,
            'admission_semester' => 'Spring',
            'admission_year' => 2024
        ];
        
        // Get user's current academic level and term based on saved grades
        $latestGrade = StudentCourse::where('user_id', $user->id ?? 1)
            ->orderBy('year_taken', 'desc')
            ->orderBy('semester_taken', 'desc')
            ->first();
            
        if ($latestGrade) {
            // Check if current semester has all grades, if so move to next
            $currentLevel = $latestGrade->year_taken;
            $currentTerm = $latestGrade->semester_taken;
            
            // Get course count for this semester
            $dept = Department::where('code', 'CSE')->first();
            $expectedCourses = Course::where('level', $currentLevel)
                ->where('term', $currentTerm)
                ->where('department_id', $dept->id ?? 1)
                ->count();
                
            $completedCourses = StudentCourse::where('user_id', $user->id ?? 1)
                ->where('year_taken', $currentLevel)
                ->where('semester_taken', $currentTerm)
                ->count();
                
            // If all courses are completed, move to next semester
            if ($completedCourses >= $expectedCourses) {
                if ($currentTerm < 3) {
                    $currentTerm++;
                } else {
                    $currentLevel++;
                    $currentTerm = 1;
                }
            }
        } else {
            $currentLevel = 1;
            $currentTerm = 1;
        }
        
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
        
        // Get student's completed grades
        $studentCourses = collect([]);
        if (isset($user->id)) {
            $studentCourses = StudentCourse::where('user_id', $user->id)
                ->with('course')
                ->where('status', 'completed')
                ->get();
        }
        
        // Calculate overall CGPA from all completed courses
        $totalCredits = 0;
        $totalGradePoints = 0;
        
        foreach ($studentCourses as $course) {
            $credits = $course->course->credits ?? 3;
            $totalCredits += $credits;
            $totalGradePoints += $credits * $course->grade_point;
        }
        
        $cgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
        
        // Generate allSemesters for grade input form
        $allSemesters = [];
        for ($level = 1; $level <= 4; $level++) {
            for ($term = 1; $term <= 3; $term++) {
                $semesterNames = [1 => 'Spring', 2 => 'Summer', 3 => 'Fall'];
                $semesterName = $semesterNames[$term] ?? "Term {$term}";
                $fullName = "Level {$level} - {$semesterName}";
                
                // Check if user has courses in this semester
                $hasGrades = $studentCourses->where('level', $level)->where('term', $term)->count() > 0;
                
                // Check if this semester is available for input (current or future semesters)
                $isAvailableForInput = ($level > $currentLevel) || 
                                     ($level == $currentLevel && $term >= $currentTerm);
                
                $allSemesters[$fullName] = [
                    'level' => $level,
                    'term' => $term,
                    'name' => $semesterName,
                    'has_grades' => $hasGrades,
                    'is_available_for_input' => $isAvailableForInput || !$hasGrades
                ];
            }
        }
        
        // Group courses by semester for display
        $semesterGrades = $studentCourses->groupBy(function($item) {
            return "Level {$item->year_taken} - Term {$item->semester_taken}";
        });
        
        // Calculate semester GPAs
        $semesterGPAs = [];
        foreach ($semesterGrades as $semesterKey => $grades) {
            $semesterCredits = 0;
            $semesterGradePoints = 0;
            
            foreach ($grades as $grade) {
                $credits = $grade->course->credits ?? 3;
                $semesterCredits += $credits;
                $semesterGradePoints += $credits * $grade->grade_point;
            }
            
            $semesterGPA = $semesterCredits > 0 ? $semesterGradePoints / $semesterCredits : 0;
            $semesterGPAs[$semesterKey] = round($semesterGPA, 2);
        }
        
        // Determine semester info (Spring, Summer, Fall)
        $semesterNames = [1 => 'Spring', 2 => 'Summer', 3 => 'Fall'];
        $semesterData = [];
        
        foreach ($semesterGrades as $semesterKey => $grades) {
            // Extract level and term from key
            preg_match('/Level (\d+) - Term (\d+)/', $semesterKey, $matches);
            $level = isset($matches[1]) ? (int)$matches[1] : 1;
            $term = isset($matches[2]) ? (int)$matches[2] : 1;
            
            // Calculate the correct year based on user's admission
            $calculatedYear = $this->calculateSemesterYear($user, $level, $term);
            
            $semesterData[] = [
                'key' => $semesterKey,
                'level' => $level,
                'term' => $term,
                'name' => $semesterNames[$term] ?? 'Unknown',
                'year' => $calculatedYear,
                'courses' => $grades,
                'gpa' => $semesterGPAs[$semesterKey] ?? 0,
                'credits' => $grades->sum(function($g) { return $g->course->credits ?? 3; })
            ];
        }
        
        // Calculate remaining semesters and credits for target CGPA calculation
        $remainingSemesters = $this->calculateRemainingSemesters($currentLevel, $currentTerm);
        $remainingCredits = $this->calculateRemainingCredits($currentLevel, $currentTerm, $department->code);
        
        return view('grades.index', compact(
            'semesterData',
            'semesterGPAs',
            'cgpa',
            'totalCredits',
            'totalGradePoints',
            'currentLevel',
            'currentTerm',
            'remainingSemesters',
            'remainingCredits',
            'user',
            'allSemesters'
        ));
    }
    
    /**
     * Get courses for a specific level and term via AJAX
     */
    public function getCourses(Request $request)
    {
        $level = $request->input('level');
        $term = $request->input('term');
        $department = $request->input('department', 'CSE');
        
        // Log for debugging
        \Log::info("getCourses called with level={$level}, term={$term}, department={$department}");
        
        // Get department ID
        $dept = Department::where('code', $department)->first();
        if (!$dept) {
            \Log::error("Department not found: {$department}");
            return response()->json(['error' => 'Department not found'], 404);
        }
        
        $courses = Course::with('department')
            ->where('level', $level)
            ->where('term', $term)
            ->where('department_id', $dept->id)
            ->orderBy('course_code')
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'code' => $course->course_code,
                    'name' => $course->course_name,
                    'title' => $course->course_name, // For compatibility
                    'credits' => $course->credits,
                    'type' => $course->course_type,
                    'level' => $course->level,
                    'term' => $course->term
                ];
            });
        
        \Log::info("Found " . count($courses) . " courses");
        
        return response()->json($courses);
    }
    
    /**
     * Save/Update student grades
     */
    public function saveGrades(Request $request)
    {
        try {
            $request->validate([
                'level' => 'required|integer|min:1|max:4',
                'term' => 'required|integer|min:1|max:3',
                'grades' => 'required|array',
                'grades.*.course_code' => 'required|string',
                'grades.*.grade' => 'required|string|in:A+,A,A-,B+,B,B-,C+,C,C-,D+,D,F',
                'grades.*.credits' => 'required|numeric|min:0.5|max:6'
            ]);
            
            $user = Auth::user() ?? (object)['id' => 1];
            
            // Grade point mapping
            $gradePoints = [
                'A+' => 4.00, 'A' => 3.75, 'A-' => 3.50,
                'B+' => 3.25, 'B' => 3.00, 'B-' => 2.75,
                'C+' => 2.50, 'C' => 2.25, 'C-' => 2.00,
                'D+' => 1.75, 'D' => 1.50, 'F' => 0.00
            ];
            
            // Get or create department
            $department = Department::firstOrCreate(
                ['code' => 'CSE'],
                [
                    'name' => 'Computer Science and Engineering',
                    'description' => 'Department of Computer Science and Engineering'
                ]
            );
            
            foreach ($request->grades as $gradeData) {
                // Find or create course record
                $course = Course::firstOrCreate(
                    ['course_code' => $gradeData['course_code']],
                    [
                        'course_name' => $gradeData['course_name'] ?? $gradeData['course_code'],
                        'credits' => $gradeData['credits'],
                        'level' => $request->level,
                        'term' => $request->term,
                        'department_id' => $department->id,
                        'course_type' => 'Core Theory',
                        'description' => '',
                        'is_active' => true
                    ]
                );
                
                // Save/update student course grade
                StudentCourse::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id
                    ],
                    [
                        'grade' => $gradeData['grade'],
                        'grade_point' => $gradePoints[$gradeData['grade']],
                        'status' => 'completed',
                        'semester_taken' => $request->term,
                        'year_taken' => $request->level
                    ]
                );
            }
            
            return response()->json([
                'success' => true,
                'message' => "Grades saved successfully for Level {$request->level} - Term {$request->term}",
                'saved_count' => count($request->grades),
                'redirect' => route('grades.index')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error saving grades: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error saving grades: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Calculate required CGPA for target
     */
    public function calculateTargetCGPA(Request $request)
    {
        $request->validate([
            'target_cgpa' => 'required|numeric|min:0|max:4',
            'current_cgpa' => 'required|numeric|min:0|max:4',
            'completed_credits' => 'required|numeric|min:0',
            'remaining_credits' => 'required|numeric|min:0'
        ]);
        
        $targetCGPA = $request->target_cgpa;
        $currentCGPA = $request->current_cgpa;
        $completedCredits = $request->completed_credits;
        $remainingCredits = $request->remaining_credits;
        
        // Calculate required GPA for remaining courses
        // Formula: (Target * Total Credits) - (Current * Completed Credits) = Required * Remaining Credits
        $totalCredits = $completedCredits + $remainingCredits;
        $requiredGradePoints = ($targetCGPA * $totalCredits) - ($currentCGPA * $completedCredits);
        $requiredGPA = $remainingCredits > 0 ? $requiredGradePoints / $remainingCredits : 0;
        
        $achievable = $requiredGPA <= 4.0;
        
        return response()->json([
            'required_gpa' => round($requiredGPA, 2),
            'achievable' => $achievable,
            'message' => $achievable 
                ? "You need an average GPA of " . round($requiredGPA, 2) . " in remaining courses."
                : "Target CGPA is not achievable with remaining credits."
        ]);
    }
    
    /**
     * Calculate remaining semesters based on current academic progress
     */
    private function calculateRemainingSemesters($currentLevel, $currentTerm)
    {
        $totalSemesters = 12; // 4 levels * 3 terms each
        $completedSemesters = ($currentLevel - 1) * 3 + ($currentTerm - 1);
        return max(0, $totalSemesters - $completedSemesters);
    }
    
    /**
     * Calculate remaining credits for degree completion
     */
    private function calculateRemainingCredits($currentLevel, $currentTerm, $department)
    {
        // Get total credits from remaining semesters
        $remainingCredits = 0;
        
        for ($level = $currentLevel; $level <= 4; $level++) {
            $startTerm = ($level == $currentLevel) ? $currentTerm : 1;
            
            for ($term = $startTerm; $term <= 3; $term++) {
                $dept = Department::where('code', $department)->first();
                $semesterCredits = Course::where('level', $level)
                    ->where('term', $term)
                    ->where('department_id', $dept->id ?? 1)
                    ->sum('credits');
                
                $remainingCredits += $semesterCredits;
            }
        }
        
        return $remainingCredits;
    }
    
    /**
     * Get grade point for a letter grade
     */
    private function getGradePoint($grade)
    {
        $gradePoints = [
            'A+' => 4.00,
            'A' => 3.75,
            'A-' => 3.50,
            'B+' => 3.25,
            'B' => 3.00,
            'B-' => 2.75,
            'C+' => 2.50,
            'C' => 2.25,
            'C-' => 2.00,
            'D+' => 1.75,
            'D' => 1.50,
            'F' => 0.00
        ];
        
        return $gradePoints[$grade] ?? 0;
    }
    
    /**
     * Calculate required GPA for target CGPA
     */
    public function calculateTargetGPA(Request $request)
    {
        $request->validate([
            'target_cgpa' => 'required|numeric|min:0|max:4',
            'remaining_credits' => 'required|integer|min:1'
        ]);
        
        $user = Auth::user() ?? (object)['id' => 1];
        
        // Get current completed courses
        $completedCourses = StudentCourse::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('course')
            ->get();
        
        $currentCredits = $completedCourses->sum(function($sc) {
            return $sc->course->credits;
        });
        
        $currentGradePoints = $completedCourses->sum(function($sc) {
            return $sc->course->credits * $sc->grade_point;
        });
        
        $targetCGPA = $request->target_cgpa;
        $remainingCredits = $request->remaining_credits;
        $totalCredits = $currentCredits + $remainingCredits;
        
        // Calculate required grade points for target CGPA
        $requiredTotalGradePoints = $targetCGPA * $totalCredits;
        $requiredRemainingGradePoints = $requiredTotalGradePoints - $currentGradePoints;
        $requiredGPA = $remainingCredits > 0 ? $requiredRemainingGradePoints / $remainingCredits : 0;
        
        $currentCGPA = $currentCredits > 0 ? $currentGradePoints / $currentCredits : 0;
        
        return response()->json([
            'current_cgpa' => round($currentCGPA, 2),
            'current_credits' => $currentCredits,
            'required_gpa' => round($requiredGPA, 2),
            'remaining_credits' => $remainingCredits,
            'target_cgpa' => $targetCGPA,
            'is_achievable' => $requiredGPA <= 4.0 && $requiredGPA >= 0
        ]);
    }
    
    /**
     * Get semester statistics
     */
    public function semesterStats(Request $request)
    {
        $user = Auth::user() ?? (object)['id' => 1];
        $level = $request->level;
        $term = $request->term;
        
        $courses = StudentCourse::where('user_id', $user->id)
            ->where('year_taken', $level)
            ->where('semester_taken', $term)
            ->where('status', 'completed')
            ->with('course')
            ->get();
        
        $totalCredits = $courses->sum(function($sc) {
            return $sc->course->credits;
        });
        
        $totalGradePoints = $courses->sum(function($sc) {
            return $sc->course->credits * $sc->grade_point;
        });
        
        $gpa = $totalCredits > 0 ? $totalGradePoints / $totalCredits : 0;
        
        return response()->json([
            'gpa' => round($gpa, 2),
            'total_credits' => $totalCredits,
            'total_courses' => $courses->count(),
            'grade_distribution' => $courses->groupBy('grade')->map->count()
        ]);
    }
    
    /**
     * Calculate the correct semester year based on user's admission and level progression
     * Handles both bi-semester and tri-semester systems
     */
    private function calculateSemesterYear($user, $level, $term)
    {
        // Get user's admission information
        $admissionYear = $user->admission_year ?? date('Y');
        $admissionSemester = $user->admission_semester ?? 'Spring';
        
        // Determine semester system type based on available terms
        // You can make this configurable in the future
        $semesterSystem = 'tri'; // 'bi' for bi-semester, 'tri' for tri-semester
        
        if ($semesterSystem === 'bi') {
            // Bi-semester system: Spring (1), Fall (3) - Skip Summer (2)
            $admissionTermMap = [
                'Spring' => 1,
                'Fall' => 3
            ];
            $semesterNames = [1 => 'Spring', 3 => 'Fall'];
        } else {
            // Tri-semester system: Spring (1), Summer (2), Fall (3)
            $admissionTermMap = [
                'Spring' => 1,
                'Summer' => 2, 
                'Fall' => 3
            ];
            $semesterNames = [1 => 'Spring', 2 => 'Summer', 3 => 'Fall'];
        }
        
        $admissionTerm = $admissionTermMap[$admissionSemester] ?? 1;
        
        // Calculate years from admission based on level progression
        // Level 1 = admission year, Level 2 = admission year + 1, etc.
        $yearsFromAdmission = $level - 1;
        $calculatedYear = $admissionYear + $yearsFromAdmission;
        
        // Special handling: If current term is earlier than admission term in Level 1,
        // it would be from the previous year (shouldn't normally happen)
        if ($level == 1 && $term < $admissionTerm) {
            $calculatedYear = $admissionYear - 1;
        }
        
        return $calculatedYear;
    }
}
