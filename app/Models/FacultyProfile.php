<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'designation',
        'department_id',
        'bio',
        'office_location',
        'phone',
        'specializations',
        'average_rating',
        'total_reviews',
        'is_verified'
    ];

    protected $casts = [
        'specializations' => 'array',
        'average_rating' => 'decimal:2',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user that owns the faculty profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that owns the faculty profile
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the faculty reviews for the faculty
     */
    public function facultyReviews()
    {
        return $this->hasMany(FacultyReview::class, 'faculty_id');
    }

    /**
     * Get approved reviews only
     */
    public function approvedReviews()
    {
        return $this->facultyReviews()->where('is_approved', true);
    }

    /**
     * Update average rating based on approved reviews
     */
    public function updateRating()
    {
        $reviews = $this->approvedReviews();
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating');

        $this->update([
            'total_reviews' => $totalReviews,
            'average_rating' => $averageRating ? round($averageRating, 2) : 0.00
        ]);
    }

    /**
     * Get verified faculty only
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
