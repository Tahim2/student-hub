@extends('layouts.faculty')

@section('title', 'Course Students - ' . $course->course_code)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <!-- Breadcrumb -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('faculty.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('faculty.courses') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">My Courses</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-sm font-medium text-gray-500">{{ $course->course_code }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-3xl font-bold text-gray-900">{{ $course->course_code }} - Students</h1>
            <p class="text-gray-600 mt-2">{{ $course->course_name }}</p>
        </div>
        <div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>Export List
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $total_students }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Credits</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $course->credits }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-credit-card text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Semester</p>
                    <p class="text-xl font-bold text-gray-900">{{ $current_semester }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-calendar text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Department</p>
                    <p class="text-lg font-bold text-gray-900">{{ $course->department->name ?? 'N/A' }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-building text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Info Card -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Course Information</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="space-y-3">
                        <div class="flex">
                            <span class="font-medium text-gray-900 w-32">Course Code:</span>
                            <span class="text-gray-700">{{ $course->course_code }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-medium text-gray-900 w-32">Course Name:</span>
                            <span class="text-gray-700">{{ $course->course_name }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-medium text-gray-900 w-32">Credits:</span>
                            <span class="text-gray-700">{{ $course->credits }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="space-y-3">
                        <div class="flex">
                            <span class="font-medium text-gray-900 w-32">Department:</span>
                            <span class="text-gray-700">{{ $course->department->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-medium text-gray-900 w-32">Level:</span>
                            <span class="text-gray-700">{{ $course->level ?? 'N/A' }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-medium text-gray-900 w-32">Type:</span>
                            <span class="text-gray-700">{{ $course->course_type ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @if($course->description)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <span class="font-medium text-gray-900">Description:</span>
                    <p class="text-gray-700 mt-2">{{ $course->description }}</p>
                </div>
            @endif
        </div>
    </div>
    <!-- Students List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Enrolled Students - {{ $current_semester }}</h2>
            <div class="relative">
                <input type="text" id="studentSearch" placeholder="Search students..." 
                       class="w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>

        @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="studentsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if(isset($student->user) && $student->user->profile_picture)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $student->user->profile_picture) }}" alt="{{ $student->user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ isset($student->user) ? substr($student->user->name, 0, 1) : substr($student->name ?? 'S', 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ isset($student->user) ? $student->user->name : $student->name ?? 'Unknown Student' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: {{ isset($student->user) ? 'STU' . str_pad($student->user->id, 6, '0', STR_PAD_LEFT) : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ isset($student->user) ? $student->user->email : $student->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ ($student->status ?? 'enrolled') === 'enrolled' ? 'bg-green-100 text-green-800' : 
                                       (($student->status ?? 'enrolled') === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($student->status ?? 'Enrolled') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($student->grade ?? null)
                                    <span class="font-medium">{{ $student->grade }}</span>
                                    @if($student->grade_point ?? null)
                                        <span class="text-gray-500">({{ $student->grade_point }})</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">Not graded</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i>View Profile
                                </button>
                                <button class="text-green-600 hover:text-green-900 transition-colors duration-200">
                                    <i class="fas fa-edit mr-1"></i>Grade
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Enrolled</h3>
                <p class="text-gray-500 mb-4">No students are currently enrolled in this course for {{ $current_semester }}.</p>
                <div class="text-sm text-gray-400">
                    Students will appear here once they enroll in the course.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search functionality
document.getElementById('studentSearch').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#studentsTable tbody tr');
    
    tableRows.forEach(row => {
        const studentName = row.cells[0].textContent.toLowerCase();
        const studentEmail = row.cells[1].textContent.toLowerCase();
        
        if (studentName.includes(searchValue) || studentEmail.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endpush
                                                <img src="{{ Storage::url($student->profile_picture) }}" 
                                                     class="rounded-circle" width="40" height="40" alt="Avatar">
                                            @else
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white font-weight-bold">
                                                        {{ substr($student->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $student->name }}</div>
                                            <small class="text-muted">{{ $student->role }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                title="View Profile">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                title="Send Message">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                                title="View Grades">
                                            <i class="fas fa-chart-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-gray-300"></i>
                    </div>
                    <h5 class="text-gray-600">No Students Enrolled</h5>
                    <p class="text-muted">No students have enrolled in this course yet.</p>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Students
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-file-upload"></i> Upload Grades
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-calendar-plus"></i> Schedule Class
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-bell"></i> Send Announcement
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="fas fa-chart-bar"></i> Course Analytics
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-plus text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">2 hours ago</div>
                                    <div>New student enrolled</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">1 day ago</div>
                                    <div>Assignment uploaded</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-comments text-warning"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-muted">3 days ago</div>
                                    <div>New course review received</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="faculty-footer" style="margin-left: 0; transition: margin-left 0.3s ease;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                    <div class="col-md-4 d-flex align-items-center">
                        <span class="text-muted">&copy; 2025 Student Hub - Faculty Portal</span>
                    </div>
                    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                        <li class="ms-3"><a class="text-muted" href="{{ route('faculty.dashboard') }}">Dashboard</a></li>
                        <li class="ms-3"><a class="text-muted" href="{{ route('faculty.courses') }}">My Courses</a></li>
                        <li class="ms-3"><a class="text-muted" href="#profile">Profile</a></li>
                        <li class="ms-3"><a class="text-muted" href="#settings">Settings</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle sidebar toggle for footer margin
    const sidebar = document.querySelector('.sidebar');
    const footer = document.querySelector('.faculty-footer');
    
    if (sidebar && footer) {
        // Initial state
        updateFooterMargin();
        
        // Listen for sidebar changes
        const sidebarToggle = document.querySelector('#sidebarToggle, .sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                setTimeout(updateFooterMargin, 300); // Wait for sidebar animation
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', updateFooterMargin);
    }
    
    function updateFooterMargin() {
        if (window.innerWidth > 768) { // Desktop
            if (sidebar.classList.contains('sidebar-minimized')) {
                footer.style.marginLeft = '90px';
            } else {
                footer.style.marginLeft = '224px';
            }
        } else { // Mobile
            footer.style.marginLeft = '0';
        }
    }

    // Search functionality
    const searchInput = document.getElementById('studentSearch');
    const studentsTable = document.getElementById('studentsTable');
    
    if (searchInput && studentsTable) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = studentsTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
});
</script>

<style>
.faculty-footer {
    background-color: #f8f9fc;
    border-top: 1px solid #e3e6f0;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .faculty-footer {
        margin-left: 0 !important;
    }
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.list-group-item:hover {
    background-color: #f8f9fc;
}
</style>
@endsection
