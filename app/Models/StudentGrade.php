<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'semester_id',
        'grade',
        'grade_points',
        'credit_hours',
        'quality_points',
        'notes'
    ];

    protected $casts = [
        'grade_points' => 'decimal:2',
        'quality_points' => 'decimal:2',
    ];

    /**
     * Get the student that owns the grade
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the course for the grade
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the semester for the grade
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get grades by student
     */
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Get grades by semester
     */
    public function scopeBySemester($query, $semesterId)
    {
        return $query->where('semester_id', $semesterId);
    }

    /**
     * Calculate GPA for a given student and semester
     */
    public static function calculateGPA($studentId, $semesterId)
    {
        $grades = self::where('student_id', $studentId)
                     ->where('semester_id', $semesterId)
                     ->get();

        if ($grades->isEmpty()) return 0;

        $totalQualityPoints = $grades->sum('quality_points');
        $totalCreditHours = $grades->sum('credit_hours');

        return $totalCreditHours > 0 ? round($totalQualityPoints / $totalCreditHours, 2) : 0;
    }

    /**
     * Calculate CGPA for a given student
     */
    public static function calculateCGPA($studentId)
    {
        $grades = self::where('student_id', $studentId)->get();

        if ($grades->isEmpty()) return 0;

        $totalQualityPoints = $grades->sum('quality_points');
        $totalCreditHours = $grades->sum('credit_hours');

        return $totalCreditHours > 0 ? round($totalQualityPoints / $totalCreditHours, 2) : 0;
    }

    /**
     * Get grade point based on letter grade
     */
    public static function getGradePoints($grade)
    {
        $gradePoints = [
            'A+' => 4.00, 'A' => 4.00, 'A-' => 3.67,
            'B+' => 3.33, 'B' => 3.00, 'B-' => 2.67,
            'C+' => 2.33, 'C' => 2.00, 'C-' => 1.67,
            'D+' => 1.33, 'D' => 1.00, 'F' => 0.00
        ];

        return $gradePoints[$grade] ?? 0.00;
    }
}
