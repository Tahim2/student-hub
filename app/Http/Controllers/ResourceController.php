<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Display the main resource hub page
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Resource::with(['course.department', 'uploader'])
            ->where('is_approved', true);

        // Filter by user's department if they are a student
        if ($user && $user->isStudent() && $user->department_id) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('tags', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Department filter
        if ($request->has('department') && $request->department) {
            $query->whereHas('course.department', function ($q) use ($request) {
                $q->where('id', $request->department);
            });
        }

        // Course filter
        if ($request->has('course') && $request->course) {
            $query->where('course_id', $request->course);
        }

        // Type filter
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if ($sortBy === 'popularity') {
            $query->orderBy('download_count', 'desc');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $resources = $query->paginate(12);

        // Get filter data
        $departments = Department::orderBy('name')->get();
        $courses = Course::orderBy('course_name')->get();
        $types = Resource::select('type')->distinct()->whereNotNull('type')->orderBy('type')->get();

        return view('resource-hub', compact('resources', 'departments', 'courses', 'types'));
    }

    /**
     * Display resources for a specific course
     */
    public function byCourse(Course $course)
    {
        $resources = Resource::with(['course.department', 'uploader'])
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('resource-hub', compact('resources', 'course'));
    }

    /**
     * Store a new resource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:file,link',
            'file' => 'nullable|file|max:10240', // 10MB max
            'external_url' => 'nullable|url',
            'tags' => 'nullable|string',
        ]);

        $resource = new Resource();
        $resource->title = $request->title;
        $resource->description = $request->description;
        $resource->course_id = $request->course_id;
        $resource->uploaded_by = Auth::id();
        $resource->type = $request->type;
        $resource->is_approved = false; // Requires admin approval

        // Handle tags
        if ($request->tags) {
            $resource->tags = array_map('trim', explode(',', $request->tags));
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('resources', $filename, 'public');
            
            $resource->file_path = $path;
            $resource->file_type = $file->getClientOriginalExtension();
            $resource->file_size = $file->getSize();
        }

        // Handle external URL
        if ($request->external_url) {
            $resource->external_url = $request->external_url;
        }

        $resource->save();

        return redirect()->route('resource-hub')->with('success', 'Resource submitted successfully and is pending approval.');
    }

    /**
     * Download a resource
     */
    public function download(Resource $resource)
    {
        if (!$resource->is_approved) {
            abort(403, 'Resource not approved');
        }

        // Increment download count
        $resource->increment('download_count');

        if ($resource->file_path) {
            return Storage::disk('public')->download($resource->file_path, $resource->title);
        } elseif ($resource->external_url) {
            return redirect($resource->external_url);
        }

        abort(404, 'Resource file not found');
    }

    /**
     * Admin: Display all resources for management
     */
    public function adminIndex(Request $request)
    {
        $query = Resource::with(['course.department', 'uploader']);

        // Filter by approval status
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('uploader', function ($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $resources = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Admin: Approve a resource
     */
    public function approve(Resource $resource)
    {
        $resource->update([
            'is_approved' => true,
            'admin_notes' => 'Approved by ' . Auth::user()->name
        ]);

        return redirect()->back()->with('success', 'Resource approved successfully.');
    }

    /**
     * Admin: Reject a resource
     */
    public function reject(Resource $resource, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $resource->update([
            'is_approved' => false,
            'admin_notes' => 'Rejected by ' . Auth::user()->name . ': ' . $request->reason
        ]);

        return redirect()->back()->with('success', 'Resource rejected.');
    }

    /**
     * Admin: Delete a resource
     */
    public function destroy(Resource $resource)
    {
        // Delete file if exists
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return redirect()->back()->with('success', 'Resource deleted successfully.');
    }

    /**
     * Admin: Toggle featured status
     */
    public function toggleFeatured(Resource $resource)
    {
        $resource->update([
            'is_featured' => !$resource->is_featured
        ]);

        return redirect()->back()->with('success', 'Featured status updated.');
    }
}
