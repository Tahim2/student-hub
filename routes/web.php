<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Auth;

// Home route - show welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Test route for server connectivity (no auth required)
Route::get('/test-server', function () {
    return response()->json([
        'status' => 'Server is running!',
        'timestamp' => now(),
        'php_version' => phpversion(),
        'laravel_version' => app()->version()
    ]);
});

// Test route for admin access (no auth required for debugging)
Route::get('/test-admin-access', function () {
    try {
        $facultyCount = \App\Models\User::where('role', 'faculty')->count();
        $courseCount = \App\Models\Course::count();
        $assignmentCount = \App\Models\FacultyCourseAssignment::count();
        
        return response()->json([
            'status' => 'Database connection working!',
            'faculty_users' => $facultyCount,
            'courses' => $courseCount,
            'assignments' => $assignmentCount,
            'timestamp' => now()
        ]);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Database connection failed',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Authentication routes
// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// Registration routes

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Google OAuth routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', function () {
        $user = Auth::user();
        
        // Load department relationship
        if ($user->department_id) {
            $user->load('department');
        }
        
        return view('settings', compact('user'));
    })->name('settings');
    
    // Course routes
    Route::get('/my-courses', [CourseController::class, 'myCourses'])->name('courses.my-courses');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/grade', [CourseController::class, 'updateGrade'])->name('courses.update-grade');
    
    // Grades routes
    Route::get('/grades', [App\Http\Controllers\GradeController::class, 'index'])->name('grades.index');
    Route::post('/grades', [App\Http\Controllers\GradeController::class, 'store'])->name('grades.store');
    Route::put('/grades/{grade}', [App\Http\Controllers\GradeController::class, 'update'])->name('grades.update');
    Route::delete('/grades/{grade}', [App\Http\Controllers\GradeController::class, 'destroy'])->name('grades.destroy');
    Route::get('/grades/semester-stats', [App\Http\Controllers\GradeController::class, 'semesterStats'])->name('grades.semester-stats');
    Route::post('/grades/calculate-target', [App\Http\Controllers\GradeController::class, 'calculateTargetGPA'])->name('grades.calculate-target');
    
    // CGPA Tracker (redirect to grades for backward compatibility)
    Route::get('/cgpa-tracker', function() {
        return redirect()->route('grades.index');
    })->name('cgpa-tracker');
    
    // New CGPA Tracker routes
    Route::get('/grades/courses', [App\Http\Controllers\GradeController::class, 'getCourses'])->name('grades.get-courses');
    Route::post('/grades/save', [App\Http\Controllers\GradeController::class, 'saveGrades'])->name('grades.save');
    Route::post('/grades/calculate-target', [App\Http\Controllers\GradeController::class, 'calculateTargetCGPA'])->name('grades.calculate-target');
    
    // Faculty Review routes
    Route::get('/faculty-reviews', [App\Http\Controllers\FacultyController::class, 'index'])->name('faculty-reviews.index');
    Route::get('/faculty-reviews/courses', [App\Http\Controllers\FacultyController::class, 'getCourses'])->name('faculty-reviews.get-courses');
    Route::get('/faculty-reviews/faculty', [App\Http\Controllers\FacultyController::class, 'getCourseFaculty'])->name('faculty-reviews.get-faculty');
    Route::post('/faculty-reviews/submit', [App\Http\Controllers\FacultyController::class, 'storeReview'])->name('faculty-reviews.store');
    
    // Faculty-specific routes (for faculty users)
    Route::prefix('faculty')->name('faculty.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'facultyDashboard'])->name('dashboard');
        Route::get('/my-courses', [App\Http\Controllers\DashboardController::class, 'facultyCourses'])->name('courses');
        Route::get('/course-students/{course}', [App\Http\Controllers\DashboardController::class, 'facultyCourseStudents'])->name('course-students');
    });
    
    // Profile routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [App\Http\Controllers\ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    
    // Admin routes for course management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/courses', [CourseController::class, 'adminIndex'])->name('courses.index');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    });
    
    // Admin routes for course assignments
    Route::prefix('admin/course-assignments')->name('admin.course-assignments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'store'])->name('store');
        Route::put('/{assignment}', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'update'])->name('update');
        Route::delete('/{assignment}', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-assign', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'bulkAssign'])->name('bulk-assign');
        Route::get('/courses-by-department', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'getCoursesByDepartment'])->name('courses-by-department');
        Route::get('/faculties-by-department', [App\Http\Controllers\Admin\CourseAssignmentController::class, 'getFacultiesByDepartment'])->name('faculties-by-department');
    });
});

// Test route for admin dashboard (temporary - for testing admin features)
Route::get('/test-admin', function () {
    // Get a real admin user or create a test one
    $user = \App\Models\User::where('role', 'admin')->first();
    if (!$user) {
        $user = new \stdClass();
        $user->name = 'Test Admin';
        $user->email = 'admin@diu.edu.bd';
        $user->role = 'admin';
        $user->profile_picture = null;
    }
    
    // Simulate authentication
    Auth::login($user);
    
    return redirect()->route('admin.dashboard');
})->name('test.admin');

// Test route for faculty dashboard (temporary - for testing faculty features)
Route::get('/test-faculty', function () {
    // Get a real faculty user
    $user = \App\Models\User::where('email', 'john.smith@diu.edu.bd')->first();
    
    if (!$user) {
        // Fallback to test data if user doesn't exist
        $user = new \stdClass();
        $user->name = 'Dr. John Smith';
        $user->email = 'john.smith@diu.edu.bd';
        $user->role = 'faculty';
        $user->department_id = 1;
        $user->profile_picture = null;
        $user->id = null;
    }
    
    // Call the faculty dashboard method directly (now public)
    $controller = new \App\Http\Controllers\DashboardController();
    return $controller->facultyDashboard($user);
})->name('test.faculty');

// Debug route to check users in database
Route::get('/debug/users', function() {
    $users = \App\Models\User::select('id', 'name', 'email', 'role', 'email_verified_at', 'created_at')->get();
    $faculties = \App\Models\User::where('role', 'faculty')->get();
    
    return response()->json([
        'all_users' => $users,
        'faculty_users' => $faculties,
        'faculty_count' => $faculties->count(),
        'total_users' => $users->count()
    ]);
})->name('debug.users');
