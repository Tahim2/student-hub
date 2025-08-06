<?php

namespace App\Http\Controllers;

use App\Models\FacultyReview;
use App\Models\FacultyProfile;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review
     */
    public function create(Request $request)
    {
        $facultyId = $request->get('faculty');
        $courseId = $request->get('course');

        $faculty = FacultyProfile::with(['user', 'department'])->findOrFail($facultyId);
        
        // Get courses taught by this faculty (from existing reviews) or all courses in their department
        $courses = Course::where('department_id', $faculty->department_id)
                        ->orWhereHas('facultyReviews', function ($q) use ($facultyId) {
                            $q->where('faculty_id', $facultyId);
                        })
                        ->get();

        $semesters = Semester::active()->orderBy('start_date', 'desc')->get();
        
        $selectedCourse = $courseId ? Course::find($courseId) : null;

        // Check if user already reviewed this faculty for this course
        $existingReview = null;
        if ($selectedCourse) {
            $existingReview = FacultyReview::where('student_id', Auth::id())
                                         ->where('faculty_id', $facultyId)
                                         ->where('course_id', $courseId)
                                         ->first();
        }

        return view('reviews.create', compact('faculty', 'courses', 'semesters', 'selectedCourse', 'existingReview'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculty_profiles,id',
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'semester' => 'required|string|max:50',
            'is_anonymous' => 'boolean'
        ]);

        // Check if user already reviewed this faculty for this course
        $existingReview = FacultyReview::where('student_id', Auth::id())
                                     ->where('faculty_id', $request->faculty_id)
                                     ->where('course_id', $request->course_id)
                                     ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this faculty member for this course. You can edit your existing review instead.');
        }

        $review = FacultyReview::create([
            'student_id' => Auth::id(),
            'faculty_id' => $request->faculty_id,
            'course_id' => $request->course_id,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'semester' => $request->semester,
            'is_anonymous' => $request->has('is_anonymous'),
            'is_approved' => true // Auto-approve for now, can be changed to false for moderation
        ]);

        // Update faculty average rating
        $faculty = FacultyProfile::find($request->faculty_id);
        $faculty->updateRating();

        return redirect()->route('faculty.show', $request->faculty_id)
                        ->with('success', 'Your review has been submitted successfully!');
    }

    /**
     * Show the form for editing a review
     */
    public function edit(FacultyReview $review)
    {
        // Ensure the review belongs to the authenticated user
        if ($review->student_id !== Auth::id()) {
            abort(403, 'You can only edit your own reviews.');
        }

        $faculty = $review->faculty;
        $courses = Course::where('department_id', $faculty->department_id)->get();
        $semesters = Semester::active()->orderBy('start_date', 'desc')->get();

        return view('reviews.edit', compact('review', 'faculty', 'courses', 'semesters'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, FacultyReview $review)
    {
        // Ensure the review belongs to the authenticated user
        if ($review->student_id !== Auth::id()) {
            abort(403, 'You can only edit your own reviews.');
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'semester' => 'required|string|max:50',
            'is_anonymous' => 'boolean'
        ]);

        $review->update([
            'course_id' => $request->course_id,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'semester' => $request->semester,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        // Update faculty average rating
        $review->faculty->updateRating();

        return redirect()->route('faculty.show', $review->faculty_id)
                        ->with('success', 'Your review has been updated successfully!');
    }

    /**
     * Get my reviews (for student dashboard)
     */
    public function myReviews()
    {
        $reviews = FacultyReview::with(['faculty.user', 'course'])
                               ->where('student_id', Auth::id())
                               ->latest()
                               ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }

    /**
     * Faculty can view their reviews
     */
    public function facultyReviews()
    {
        $facultyProfile = Auth::user()->facultyProfile;
        
        if (!$facultyProfile) {
            return redirect()->route('faculty.profile.setup')
                           ->with('error', 'Please complete your faculty profile first.');
        }

        $reviews = FacultyReview::with(['student', 'course'])
                               ->where('faculty_id', $facultyProfile->id)
                               ->where('is_approved', true)
                               ->latest()
                               ->paginate(15);

        return view('faculty.reviews', compact('reviews', 'facultyProfile'));
    }

    /**
     * Admin review management
     */
    public function adminIndex()
    {
        $reviews = FacultyReview::with(['student', 'faculty.user', 'course'])
                               ->latest()
                               ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Approve a review (Admin only)
     */
    public function approve(FacultyReview $review)
    {
        $review->update(['is_approved' => true, 'is_flagged' => false]);
        $review->faculty->updateRating();

        return back()->with('success', 'Review approved successfully.');
    }

    /**
     * Flag a review (Admin only)
     */
    public function flag(FacultyReview $review, Request $request)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $review->update([
            'is_flagged' => true,
            'is_approved' => false,
            'admin_notes' => $request->admin_notes
        ]);

        $review->faculty->updateRating();

        return back()->with('success', 'Review flagged successfully.');
    }

    /**
     * Delete a review (Student can delete their own review)
     */
    public function destroy(FacultyReview $review)
    {
        // Check if user owns this review
        if ($review->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $faculty = $review->faculty;
        $review->delete();
        
        // Update faculty rating after deletion
        $faculty->updateRating();

        return redirect()->route('reviews.my')->with('success', 'Review deleted successfully.');
    }
}
