<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'semester_type',
        'description',
        'head_of_department',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the courses for the department
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the faculty profiles for the department
     */
    public function facultyProfiles()
    {
        return $this->hasMany(FacultyProfile::class);
    }

    /**
     * Get only active departments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
