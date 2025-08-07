<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'start_date',
        'end_date',
        'is_current',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the student grades for the semester
     */
    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    /**
     * Get active semesters only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get current semester
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Set current semester (ensures only one current semester)
     */
    public function setCurrent()
    {
        // Remove current flag from all semesters
        self::where('is_current', true)->update(['is_current' => false]);
        
        // Set this semester as current
        $this->update(['is_current' => true]);
    }
}
