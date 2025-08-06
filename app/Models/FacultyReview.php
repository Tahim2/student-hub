<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'faculty_id',
        'course_id',
        'overall_rating',
        'teaching_quality',
        'communication',
        'course_organization',
        'helpfulness',
        'fairness',
        'review_text',
        'is_anonymous',
        'is_approved',
        'is_flagged',
        'admin_notes'
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_approved' => 'boolean',
        'is_flagged' => 'boolean',
    ];

    /**
     * Get the user that wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the faculty member being reviewed
     */
    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    /**
     * Get the course for which the review was written
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get approved reviews only
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Get non-flagged reviews only
     */
    public function scopeNotFlagged($query)
    {
        return $query->where('is_flagged', false);
    }

    /**
     * Get reviews by faculty
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Get reviews by course
     */
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
}
