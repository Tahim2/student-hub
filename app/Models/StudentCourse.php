<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'grade',
        'grade_point',
        'semester_taken',
        'year_taken'
    ];

    protected $casts = [
        'grade_point' => 'decimal:2',
    ];

    /**
     * Get the user (student) for this enrollment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course for this enrollment
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get only completed courses
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get only enrolled courses
     */
    public function scopeEnrolled($query)
    {
        return $query->where('status', 'enrolled');
    }

    /**
     * Get courses by semester
     */
    public function scopeBySemester($query, $semester, $year)
    {
        return $query->where('semester_taken', $semester)->where('year_taken', $year);
    }

    /**
     * Calculate GPA for a specific semester
     */
    public static function calculateSemesterGPA($userId, $semester, $year)
    {
        $courses = self::where('user_id', $userId)
            ->where('semester_taken', $semester)
            ->where('year_taken', $year)
            ->where('status', 'completed')
            ->with('course')
            ->get();

        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($courses as $studentCourse) {
            $credits = $studentCourse->course->credits;
            $gradePoint = $studentCourse->grade_point;
            
            $totalCredits += $credits;
            $totalGradePoints += ($gradePoint * $credits);
        }

        return $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
    }

    /**
     * Calculate overall CGPA
     */
    public static function calculateCGPA($userId)
    {
        $courses = self::where('user_id', $userId)
            ->where('status', 'completed')
            ->with('course')
            ->get();

        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($courses as $studentCourse) {
            $credits = $studentCourse->course->credits;
            $gradePoint = $studentCourse->grade_point;
            
            $totalCredits += $credits;
            $totalGradePoints += ($gradePoint * $credits);
        }

        return $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
    }
}
