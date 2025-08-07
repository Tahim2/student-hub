<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprehensiveCourse extends Model
{
    use HasFactory;

    protected $table = 'comprehensive_courses';

    protected $fillable = [
        'code',
        'title',
        'type',
        'credits',
        'level',
        'term',
        'department',
        'description',
        'is_elective',
        'elective_type'
    ];

    protected $casts = [
        'credits' => 'decimal:1',
        'is_elective' => 'boolean',
    ];

    // Scope to get courses by level
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    // Scope to get courses by term
    public function scopeByTerm($query, $term)
    {
        return $query->where('term', $term);
    }

    // Scope to get courses by level and term
    public function scopeByLevelAndTerm($query, $level, $term)
    {
        return $query->where('level', $level)->where('term', $term);
    }

    // Scope to get elective courses
    public function scopeElectives($query)
    {
        return $query->where('is_elective', true);
    }

    // Scope to get core courses
    public function scopeCore($query)
    {
        return $query->where('is_elective', false);
    }

    // Get formatted semester (e.g., "Level 1 Term 1")
    public function getFormattedSemesterAttribute()
    {
        return "Level {$this->level} Term {$this->term}";
    }

    // Check if course is a lab course
    public function getIsLabAttribute()
    {
        return $this->type === 'lab';
    }

    // Get total credits for a specific level and term
    public static function getTotalCredits($level, $term)
    {
        return static::byLevelAndTerm($level, $term)->sum('credits');
    }

    // Get all unique levels
    public static function getLevels()
    {
        return static::distinct('level')->orderBy('level')->pluck('level');
    }

    // Get all terms for a specific level
    public static function getTermsForLevel($level)
    {
        return static::where('level', $level)->distinct('term')->orderBy('term')->pluck('term');
    }
}
