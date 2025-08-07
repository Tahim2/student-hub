<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'uploaded_by',
        'title',
        'description',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'resource_type',
        'download_count',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * Get the course this resource belongs to
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who uploaded this resource
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get only active resources
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get resources by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('resource_type', $type);
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    /**
     * Get file size in human readable format
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
