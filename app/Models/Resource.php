<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'uploaded_by',
        'type',
        'file_path',
        'google_drive_id',
        'external_url',
        'file_type',
        'file_size',
        'tags',
        'download_count',
        'is_approved',
        'is_featured',
        'admin_notes'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the course that owns the resource
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who uploaded the resource
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get approved resources only
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Get featured resources only
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get resources by course
     */
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Get resources by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Search resources by tags
     */
    public function scopeWithTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Increment download count
     */
    public function incrementDownloads()
    {
        $this->increment('download_count');
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return null;
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
