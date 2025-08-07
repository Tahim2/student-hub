<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'credits',
        'department_id',
        'course_type',
        'level',
        'term',
        'prerequisites',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the department that owns the course
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the faculty reviews for the course
     */
    public function facultyReviews()
    {
        return $this->hasMany(FacultyReview::class);
    }

    /**
     * Get the resources for the course
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the course resources for the course
     */
    public function courseResources()
    {
        return $this->hasMany(CourseResource::class);
    }

    /**
     * Get the student grades for the course
     */
    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    /**
     * Get the student course enrollments
     */
    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    /**
     * Get only active courses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get courses by department
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Get courses by level and term
     */
    public function scopeByLevelAndTerm($query, $level, $term)
    {
        return $query->where('level', $level)->where('term', $term);
    }

    /**
     * Get courses by semester (level and term combined)
     */
    public function scopeBySemester($query, $level, $term)
    {
        return $query->where('level', $level)->where('term', $term);
    }
}
