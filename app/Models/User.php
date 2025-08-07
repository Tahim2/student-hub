<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'student_id',
        'password',
        'role',
        'department_id',
        'admission_semester',
        'admission_year',
        'profile_picture',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is a student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Check if user is faculty
     */
    public function isFaculty(): bool
    {
        return $this->role === 'faculty';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Calculate the current semester number for a student based on admission date
     */
    public function getCurrentSemesterNumber(): int
    {
        if (!$this->isStudent() || !$this->admission_semester || !$this->admission_year) {
            return 1; // Default to first semester
        }

        $currentDate = now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;
        
        // Determine current semester type based on month
        $currentSemesterType = '';
        if ($currentMonth >= 1 && $currentMonth <= 4) {
            $currentSemesterType = 'Spring';
        } elseif ($currentMonth >= 5 && $currentMonth <= 8) {
            $currentSemesterType = 'Summer';
        } else {
            $currentSemesterType = 'Fall';
        }

        // Calculate years difference
        $yearsDiff = $currentYear - $this->admission_year;
        
        // Calculate semester progression within the year
        $semesterOrder = ['Spring' => 1, 'Summer' => 2, 'Fall' => 3];
        $admissionOrder = $semesterOrder[$this->admission_semester] ?? 1;
        $currentOrder = $semesterOrder[$currentSemesterType] ?? 1;
        
        // Calculate total semesters completed
        $totalSemesters = ($yearsDiff * 3) + ($currentOrder - $admissionOrder) + 1;
        
        // Ensure semester is within reasonable bounds (1-12 for a 4-year program)
        return max(1, min(12, $totalSemesters));
    }

    /**
     * Get semester details (level and term) from semester number
     */
    public function getCurrentSemesterDetails(): array
    {
        $semesterNumber = $this->getCurrentSemesterNumber();
        
        // Convert semester number to level and term
        // Level 1: Semesters 1-3, Level 2: Semesters 4-6, etc.
        $level = ceil($semesterNumber / 3);
        $term = (($semesterNumber - 1) % 3) + 1;
        
        $termNames = [1 => 'Spring', 2 => 'Summer', 3 => 'Fall'];
        $termName = $termNames[$term] ?? 'Spring';
        
        return [
            'semester_number' => $semesterNumber,
            'level' => $level,
            'term' => $term,
            'term_name' => $termName,
            'display' => "Level {$level} - {$termName} (Semester {$semesterNumber})"
        ];
    }

    /**
     * Get the department that the user belongs to
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the faculty profile for this user
     */
    public function facultyProfile()
    {
        return $this->hasOne(FacultyProfile::class);
    }

    /**
     * Calculate current academic level based on admission date
     */
    public function getCurrentLevel()
    {
        if (!$this->admission_year || !$this->admission_semester) {
            return 1;
        }

        $currentYear = date('Y');
        $currentSemester = $this->getCurrentSemester();
        
        $admissionYear = $this->admission_year;
        $admissionSemester = $this->admission_semester;
        
        // Calculate total semesters passed
        $yearsPassed = $currentYear - $admissionYear;
        
        if ($this->department && $this->department->semester_type === 'trisemester') {
            // Tri-semester system: Spring (1), Summer (2), Fall (3)
            $semesterOrder = ['Spring' => 1, 'Summer' => 2, 'Fall' => 3];
            $totalSemesters = ($yearsPassed * 3) + ($semesterOrder[$currentSemester] - $semesterOrder[$admissionSemester]);
        } else {
            // Bi-semester system: Spring (1), Fall (2)
            $semesterOrder = ['Spring' => 1, 'Fall' => 2];
            $totalSemesters = ($yearsPassed * 2) + ($semesterOrder[$currentSemester] - $semesterOrder[$admissionSemester]);
        }
        
        // Calculate level (each level has 3 terms for both systems)
        $level = floor($totalSemesters / 3) + 1;
        
        return min($level, 4); // Cap at level 4
    }

    /**
     * Calculate current term within the level
     */
    public function getCurrentTerm()
    {
        if (!$this->admission_year || !$this->admission_semester) {
            return 1;
        }

        $currentYear = date('Y');
        $currentSemester = $this->getCurrentSemester();
        
        $admissionYear = $this->admission_year;
        $admissionSemester = $this->admission_semester;
        
        // Calculate total semesters passed
        $yearsPassed = $currentYear - $admissionYear;
        
        if ($this->department && $this->department->semester_type === 'trisemester') {
            $semesterOrder = ['Spring' => 1, 'Summer' => 2, 'Fall' => 3];
            $totalSemesters = ($yearsPassed * 3) + ($semesterOrder[$currentSemester] - $semesterOrder[$admissionSemester]);
        } else {
            $semesterOrder = ['Spring' => 1, 'Fall' => 2];
            $totalSemesters = ($yearsPassed * 2) + ($semesterOrder[$currentSemester] - $semesterOrder[$admissionSemester]);
        }
        
        // Calculate term within level (1-3)
        $term = ($totalSemesters % 3) + 1;
        
        return min($term, 3); // Cap at term 3
    }

    /**
     * Get current semester based on date
     */
    private function getCurrentSemester()
    {
        $month = date('n');
        
        if ($month >= 1 && $month <= 4) {
            return 'Spring';
        } elseif ($month >= 5 && $month <= 8) {
            return 'Summer';
        } else {
            return 'Fall';
        }
    }
}
