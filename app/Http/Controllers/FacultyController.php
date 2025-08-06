<?php

namespace App\Http\Controllers;

use App\Models\FacultyProfile;
use App\Models\Department;
use App\Models\Course;
use App\Models\ComprehensiveCourse;
use App\Models\FacultyReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    /**
     * Display faculty review page with semester and course selection
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // If no user is authenticated, create a test student for testing
        if (!$user) {
            $user = (object)[
                'id' => 1, 
                'name' => 'Test Student', 
                'role' => 'student', 
                'department_id' => 1,
                'admission_semester' => 'Spring',
                'admission_year' => 2022
            ];
        }

        // Get student's current semester details
        $currentSemesterDetails = [];
        if ($user->role === 'student' && method_exists($user, 'getCurrentSemesterDetails')) {
            $currentSemesterDetails = $user->getCurrentSemesterDetails();
        } else {
            // Fallback for test user or non-student - Based on screenshot showing Level 4 - Summer (Semester 11)
            $currentSemesterDetails = [
                'semester_number' => 11,
                'level' => 4,
                'term' => 1,
                'term_name' => 'Summer',
                'display' => 'Level 4 - Summer (Semester 11)'
            ];
        }

        // Get current semester info for faculty assignments
        $currentDate = now();
        $currentYear = $currentDate->year;
        $currentSemesterType = 'Summer'; // Based on the screenshot

        // Get faculty assignments for the current semester directly
        $facultyAssignments = \App\Models\FacultyCourseAssignment::with(['faculty', 'course'])
            ->whereHas('course', function($query) use ($currentSemesterDetails) {
                $query->where('level', $currentSemesterDetails['level'])
                      ->where('term', $currentSemesterDetails['term']);
            })
            ->where('academic_year', $currentYear)
            ->where('semester_type', $currentSemesterType)
            ->where('is_active', true)
            ->get();

        return view('faculty-reviews', compact('currentSemesterDetails', 'facultyAssignments', 'user'));
    }

    /**
     * Get courses for selected semester (AJAX)
     */
    public function getCourses(Request $request)
    {
        $level = $request->get('level');
        $term = $request->get('term');

        if (!$level || !$term) {
            return response()->json(['error' => 'Level and term are required'], 400);
        }

        $courses = ComprehensiveCourse::where('level', $level)
            ->where('term', $term)
            ->where('department', 'CSE') // Assuming CSE department
            ->select('id', 'code', 'title', 'credits')
            ->get();

        return response()->json(['courses' => $courses]);
    }

    /**
     * Get faculty for selected course (AJAX)
     */
    public function getCourseFaculty(Request $request)
    {
        $courseId = $request->get('course_id');
        
        if (!$courseId) {
            return response()->json(['error' => 'Course ID is required'], 400);
        }

        // Get faculty assigned to this course for current semester
        $currentDate = now();
        $currentYear = $currentDate->year;
        
        // Determine current semester based on month
        if ($currentDate->month >= 1 && $currentDate->month <= 4) {
            $semesterType = 'Spring';
        } elseif ($currentDate->month >= 5 && $currentDate->month <= 8) {
            $semesterType = 'Summer';
        } else {
            $semesterType = 'Fall';
        }

        // Find faculty assignment for this course in current semester
        $assignment = \App\Models\FacultyCourseAssignment::with(['faculty', 'course'])
            ->where('course_id', $courseId)
            ->where('academic_year', $currentYear)
            ->where('semester_type', $semesterType)
            ->where('is_active', true)
            ->first();

        if (!$assignment) {
            return response()->json(['error' => 'No faculty assigned to this course for ' . $semesterType . ' ' . $currentYear], 404);
        }

        // Format faculty data for frontend
        $facultyData = [
            'id' => $assignment->faculty->id,
            'name' => $assignment->faculty->name,
            'email' => $assignment->faculty->email,
            'assignment_id' => $assignment->id,
            'semester' => $assignment->semester,
            'course' => [
                'id' => $assignment->course->id,
                'code' => $assignment->course->course_code,
                'name' => $assignment->course->course_name
            ]
        ];

        return response()->json(['faculty' => $facultyData]);
    }

    /**
     * Store faculty review
     */
    public function storeReview(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('Faculty review submission data:', $request->all());
            
            $request->validate([
                'faculty_id' => 'required|exists:users,id',
                'course_id' => 'required|exists:courses,id',
                'overall_rating' => 'required|integer|min:1|max:5',
                'teaching_quality' => 'required|integer|min:1|max:5',
                'communication' => 'required|integer|min:1|max:5',
                'course_organization' => 'required|integer|min:1|max:5',
                'helpfulness' => 'required|integer|min:1|max:5',
                'fairness' => 'required|integer|min:1|max:5',
                'review_text' => 'nullable|string|max:1000',
                'anonymous' => 'nullable|boolean'
            ]);

            $user = Auth::user() ?? (object)['id' => 1];

        // Verify that the faculty is actually assigned to this course for current semester
        $currentDate = now();
        $currentYear = $currentDate->year;
        
        if ($currentDate->month >= 1 && $currentDate->month <= 4) {
            $semesterType = 'Spring';
        } elseif ($currentDate->month >= 5 && $currentDate->month <= 8) {
            $semesterType = 'Summer';
        } else {
            $semesterType = 'Fall';
        }

        $assignment = \App\Models\FacultyCourseAssignment::where([
            'faculty_id' => $request->faculty_id,
            'course_id' => $request->course_id,
            'academic_year' => $currentYear,
            'semester_type' => $semesterType,
            'is_active' => true
        ])->first();

        if (!$assignment) {
            return response()->json(['error' => 'This faculty is not assigned to the selected course for the current semester'], 422);
        }

        // Check if user has already reviewed this faculty for this course
        $existingReview = FacultyReview::where('faculty_id', $request->faculty_id)
            ->where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingReview) {
            return response()->json(['error' => 'You have already reviewed this faculty for this course'], 422);
        }

        // Create the review
        $review = FacultyReview::create([
            'faculty_id' => $request->faculty_id,
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'overall_rating' => $request->overall_rating,
            'teaching_quality' => $request->teaching_quality,
            'communication' => $request->communication,
            'course_organization' => $request->course_organization,
            'helpfulness' => $request->helpfulness,
            'fairness' => $request->fairness,
            'review_text' => $request->review_text,
            'is_anonymous' => $request->boolean('anonymous', false)
        ]);

        // Update faculty average rating (if FacultyProfile table exists)
        // $this->updateFacultyRating($request->faculty_id);

        return response()->json([
            'success' => true, 
            'message' => 'Review submitted successfully!',
            'review_id' => $review->id
        ]);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in faculty review:', $e->errors());
            return response()->json([
                'success' => false,
                'error' => 'Validation failed: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error storing faculty review:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while saving your review: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update faculty average rating
     */
    private function updateFacultyRating($facultyId)
    {
        $reviews = FacultyReview::where('faculty_id', $facultyId)->get();
        $averageRating = $reviews->avg('overall_rating');
        $totalReviews = $reviews->count();

        FacultyProfile::where('id', $facultyId)->update([
            'average_rating' => round($averageRating, 2),
            'total_reviews' => $totalReviews
        ]);
    }
    
    public function show($id)
    {
        $faculty = FacultyProfile::with(['user', 'department', 'approvedReviews.course', 'approvedReviews.student'])
                                ->findOrFail($id);

        // Get courses taught by this faculty (from reviews) and department courses
        $reviewedCourses = Course::whereHas('facultyReviews', function ($q) use ($id) {
            $q->where('faculty_id', $id)->where('is_approved', true);
        })->get();

        // Get all courses from faculty's department for review selection
        $departmentCourses = Course::where('department_id', $faculty->department_id)->get();
        $courses = $reviewedCourses->merge($departmentCourses)->unique('id');

        // Check if current user already reviewed this faculty
        $existingReview = null;
        if (auth()->check() && auth()->user()->isStudent()) {
            $existingReview = FacultyReview::where('faculty_id', $faculty->id)
                ->where('student_id', auth()->id())
                ->first();
        }

        // Get recent reviews
        $recentReviews = $faculty->approvedReviews()
                               ->with(['course', 'student'])
                               ->latest()
                               ->take(10)
                               ->get();

        // Calculate rating distribution
        $ratingDistribution = $faculty->approvedReviews()
                                    ->selectRaw('rating, COUNT(*) as count')
                                    ->groupBy('rating')
                                    ->orderBy('rating', 'desc')
                                    ->pluck('count', 'rating')
                                    ->toArray();

        return view('faculty.profile', compact('faculty', 'courses', 'recentReviews', 'ratingDistribution', 'existingReview'));
    }

    /**
     * Show faculty courses
     */
    public function myCourses()
    {
        $user = Auth::user();
        
        // Get current semester assignments
        $currentAssignments = \App\Models\FacultyCourseAssignment::with(['course', 'course.department'])
            ->where('faculty_id', $user->id)
            ->active()
            ->currentSemester()
            ->get();
            
        // Get all assignments for history
        $allAssignments = \App\Models\FacultyCourseAssignment::with(['course', 'course.department'])
            ->where('faculty_id', $user->id)
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester_type')
            ->get()
            ->groupBy(['academic_year', 'semester_type']);

        return view('faculty.courses', compact('currentAssignments', 'allAssignments', 'user'));
    }

    /**
     * Show students for a specific course
     */
    public function courseStudents($assignmentId)
    {
        $assignment = \App\Models\FacultyCourseAssignment::with(['course', 'course.department'])
            ->where('faculty_id', Auth::id())
            ->findOrFail($assignmentId);
            
        // In a real system, you would get actual enrolled students
        // For now, we'll show sample data
        $students = collect([
            ['id' => 1, 'name' => 'Alice Johnson', 'student_id' => 'DIU-2021-001', 'email' => 'alice@student.diu.edu.bd'],
            ['id' => 2, 'name' => 'Bob Smith', 'student_id' => 'DIU-2021-002', 'email' => 'bob@student.diu.edu.bd'],
            ['id' => 3, 'name' => 'Carol Wilson', 'student_id' => 'DIU-2021-003', 'email' => 'carol@student.diu.edu.bd'],
        ]);

        return view('faculty.course-students', compact('assignment', 'students'));
    }
}
