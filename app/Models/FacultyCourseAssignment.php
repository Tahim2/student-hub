<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyCourseAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'course_id',
        'semester',
        'academic_year',
        'semester_type',
        'is_active'
    ];

    protected $casts = [
        'academic_year' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Get the faculty member assigned to this course
     */
    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    /**
     * Get the course assigned
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope to get active assignments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get assignments for current semester
     */
    public function scopeCurrentSemester($query)
    {
        $currentYear = date('Y');
        $currentMonth = date('n');
        
        // Determine current semester based on month
        if ($currentMonth >= 1 && $currentMonth <= 4) {
            $semester = 'Spring';
        } elseif ($currentMonth >= 5 && $currentMonth <= 8) {
            $semester = 'Summer';
        } else {
            $semester = 'Fall';
        }
        
        return $query->where('academic_year', $currentYear)
                    ->where('semester_type', $semester);
    }

    /**
     * Scope to get assignments for a specific faculty
     */
    public function scopeForFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Get full semester name
     */
    public function getFullSemesterAttribute()
    {
        return $this->semester_type . ' ' . $this->academic_year;
    }
}
