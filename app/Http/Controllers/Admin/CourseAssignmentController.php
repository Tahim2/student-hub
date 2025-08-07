<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\FacultyCourseAssignment;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseAssignmentController extends Controller
{
    /**
     * Display course assignments management page
     */
    public function index()
    {
        $assignments = FacultyCourseAssignment::with(['faculty', 'course', 'course.department'])
            ->active()
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester_type')
            ->paginate(15);

        // Get all faculty users from database
        $faculties = User::where('role', 'faculty')
            ->orderBy('name')
            ->get();
            
        $courses = Course::with('department')->where('is_active', true)->orderBy('course_name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.course-assignments.index-new', compact('assignments', 'faculties', 'courses', 'departments'));
    }

    /**
     * Store a new course assignment
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Course assignment store request received', [
                'data' => $request->all(),
                'csrf_token' => $request->input('_token'),
                'session_token' => session()->token()
            ]);

            $request->validate([
                'faculty_id' => 'required|exists:users,id',
                'course_id' => 'required|exists:courses,id'
            ]);

            // Check if faculty user has role 'faculty'
            $faculty = User::findOrFail($request->faculty_id);
            if ($faculty->role !== 'faculty') {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Selected user is not a faculty member.'], 422);
                }
                return back()->withErrors(['faculty_id' => 'Selected user is not a faculty member.']);
            }

            // Get current semester automatically based on date
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
            
            $semester = $semesterType . ' ' . $currentYear;

            // Check if assignment already exists for current semester
            $existingAssignment = FacultyCourseAssignment::where([
                'faculty_id' => $request->faculty_id,
                'course_id' => $request->course_id,
                'academic_year' => $currentYear,
                'semester_type' => $semesterType,
                'is_active' => true
            ])->first();

            if ($existingAssignment) {
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'This faculty member is already assigned to this course for ' . $semester . '.'], 422);
                }
                return back()->withErrors(['assignment' => 'This faculty member is already assigned to this course for ' . $semester . '.']);
            }

            $assignment = FacultyCourseAssignment::create([
                'faculty_id' => $request->faculty_id,
                'course_id' => $request->course_id,
                'semester' => $semester,
                'academic_year' => $currentYear,
                'semester_type' => $semesterType,
                'is_active' => true
            ]);

            \Log::info('Course assignment created successfully', ['assignment_id' => $assignment->id]);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Course assignment created successfully for ' . $semester . '!']);
            }
            return back()->with('success', 'Course assignment created successfully for ' . $semester . '!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Validation failed', 'errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Course assignment error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            $errorMsg = 'An error occurred while creating the assignment: ' . $e->getMessage();
            
            if ($request->expectsJson()) {
                return response()->json(['error' => $errorMsg], 500);
            }
            return back()->withErrors(['assignment' => $errorMsg]);
        }
    }

    /**
     * Update an existing assignment
     */
    public function update(Request $request, FacultyCourseAssignment $assignment)
    {
        $request->validate([
            'faculty_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year' => 'required|integer|min:2020|max:2030',
            'semester_type' => 'required|in:Spring,Summer,Fall',
            'is_active' => 'boolean'
        ]);

        // Check if faculty user has role 'faculty'
        $faculty = User::findOrFail($request->faculty_id);
        if ($faculty->role !== 'faculty') {
            return back()->withErrors(['faculty_id' => 'Selected user is not a faculty member.']);
        }

        // Create semester string
        $semester = $request->semester_type . ' ' . $request->academic_year;

        try {
            $assignment->update([
                'faculty_id' => $request->faculty_id,
                'course_id' => $request->course_id,
                'semester' => $semester,
                'academic_year' => $request->academic_year,
                'semester_type' => $request->semester_type,
                'is_active' => $request->has('is_active')
            ]);

            return back()->with('success', 'Course assignment updated successfully!');
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'faculty_course_unique') !== false) {
                return back()->withErrors(['assignment' => 'This faculty member is already assigned to this course for the selected semester.']);
            }
            return back()->withErrors(['assignment' => 'An error occurred while updating the assignment.']);
        }
    }

    /**
     * Remove an assignment
     */
    public function destroy(FacultyCourseAssignment $assignment)
    {
        $assignment->delete();
        return back()->with('success', 'Course assignment removed successfully!');
    }

    /**
     * Get courses by department (AJAX)
     */
    public function getCoursesByDepartment(Request $request)
    {
        $departmentId = $request->get('department_id');
        
        if (!$departmentId) {
            $courses = Course::where('is_active', true)
                ->select('id', 'course_code', 'course_name', 'credits', 'level', 'term')
                ->orderBy('level')
                ->orderBy('term')
                ->orderBy('course_code')
                ->get();
        } else {
            $courses = Course::where('department_id', $departmentId)
                ->where('is_active', true)
                ->select('id', 'course_code', 'course_name', 'credits', 'level', 'term')
                ->orderBy('level')
                ->orderBy('term')
                ->orderBy('course_code')
                ->get();
        }

        return response()->json($courses);
    }

    /**
     * Get faculties by department (AJAX endpoint)
     */
    public function getFacultiesByDepartment(Request $request)
    {
        $departmentId = $request->get('department_id');
        
        if (!$departmentId) {
            // Return all faculties if no department selected
            $faculties = User::where('role', 'faculty')
                ->orderBy('name')
                ->get(['id', 'name', 'email']);
        } else {
            // Get faculties that belong to the selected department
            $faculties = User::where('role', 'faculty')
                ->where('department_id', $departmentId)
                ->orderBy('name')
                ->get(['id', 'name', 'email']);
        }
        
        return response()->json($faculties);
    }

    /**
     * Bulk assign courses to faculty
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:users,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
            'academic_year' => 'required|integer|min:2020|max:2030',
            'semester_type' => 'required|in:Spring,Summer,Fall'
        ]);

        // Check if faculty user has role 'faculty'
        $faculty = User::findOrFail($request->faculty_id);
        if ($faculty->role !== 'faculty') {
            return back()->withErrors(['faculty_id' => 'Selected user is not a faculty member.']);
        }

        $semester = $request->semester_type . ' ' . $request->academic_year;
        $successCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($request->course_ids as $courseId) {
                try {
                    FacultyCourseAssignment::create([
                        'faculty_id' => $request->faculty_id,
                        'course_id' => $courseId,
                        'semester' => $semester,
                        'academic_year' => $request->academic_year,
                        'semester_type' => $request->semester_type,
                        'is_active' => true
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $course = Course::find($courseId);
                    $errors[] = "Course {$course->course_code} is already assigned to this faculty.";
                }
            }

            DB::commit();
            
            $message = "Successfully assigned {$successCount} courses.";
            if (!empty($errors)) {
                $message .= " " . implode(" ", $errors);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['bulk_assign' => 'An error occurred during bulk assignment.']);
        }
    }
}
