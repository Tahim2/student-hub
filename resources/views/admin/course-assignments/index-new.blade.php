@extends('layouts.admin')

@section('title', 'Course Assignments - Admin Panel')

@section('admin-content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Course Assignments</h1>
        <p class="text-gray-600">Assign faculty members to courses for different departments and semesters.</p>
    </div>
    <button onclick="openAssignModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span>New Assignment</span>
    </button>
</div>

<!-- Filters Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="department-filter" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
            <select id="department-filter" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label for="semester-filter" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
            <select id="semester-filter" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Semesters</option>
                <option value="Spring">Spring</option>
                <option value="Fall">Fall</option>
                <option value="Summer">Summer</option>
            </select>
        </div>
        
        <div>
            <label for="year-filter" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
            <select id="year-filter" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Years</option>
                @for($year = date('Y'); $year <= date('Y') + 2; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        
        <div class="flex items-end">
            <button onclick="applyFilters()" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-filter mr-2"></i>Apply Filters
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Assignments</p>
                <p class="text-3xl font-bold text-gray-900">{{ $assignments->count() }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Active Faculty</p>
                <p class="text-3xl font-bold text-gray-900">{{ $assignments->pluck('faculty_id')->unique()->count() }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-user-tie text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Assigned Courses</p>
                <p class="text-3xl font-bold text-gray-900">{{ $assignments->pluck('course_id')->unique()->count() }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-book text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Departments</p>
                <p class="text-3xl font-bold text-gray-900">{{ $departments->count() }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-building text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Assignments Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Course Assignments</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="assignments-tbody">
                @forelse($assignments as $assignment)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($assignment->faculty->profile_picture)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($assignment->faculty->profile_picture) }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-semibold">{{ substr($assignment->faculty->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $assignment->faculty->name }}</div>
                                <div class="text-sm text-gray-500">{{ $assignment->faculty->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $assignment->course->course_code }}</div>
                        <div class="text-sm text-gray-500">{{ $assignment->course->course_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $assignment->course->department->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->semester }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->year }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button onclick="editAssignment({{ $assignment->id }})" class="text-blue-600 hover:text-blue-800 transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteAssignment({{ $assignment->id }})" class="text-red-600 hover:text-red-800 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg">No course assignments found.</p>
                        <p class="text-sm">Click "New Assignment" to create the first assignment.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Assignment Modal -->
<div id="assignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800" id="modal-title">Assign Faculty to Course</h3>
        </div>
        
        <form id="assignment-form" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="assignment-id" name="assignment_id">
            
            <div>
                <label for="department-select" class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select id="department-select" name="department_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="faculty-select" class="block text-sm font-medium text-gray-700 mb-2">Faculty Member</label>
                <select id="faculty-select" name="faculty_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled>
                    <option value="">Select Department First</option>
                </select>
            </div>
            
            <div>
                <label for="course-select" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <select id="course-select" name="course_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled>
                    <option value="">Select Department First</option>
                </select>
            </div>
            
            <!-- Current semester info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Current Semester Assignment</h3>
                        <div class="text-sm text-blue-700">
                            Assigning for: <strong>Summer 2025</strong> (automatically determined)
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 rounded-b-lg">
            <button onclick="closeAssignModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors">
                Cancel
            </button>
            <button onclick="saveAssignment()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                <span id="save-btn-text">Save Assignment</span>
            </button>
        </div>
    </div>
</div>

<script>
// Course assignments data for JavaScript access
const coursesData = @json($courses->groupBy('department_id'));
const assignmentsData = @json($assignments);

// Modal functions
function openAssignModal() {
    document.getElementById('assignmentModal').classList.remove('hidden');
    document.getElementById('assignmentModal').classList.add('flex');
    document.getElementById('modal-title').textContent = 'Assign Faculty to Course';
    document.getElementById('save-btn-text').textContent = 'Save Assignment';
    document.getElementById('assignment-form').reset();
    document.getElementById('assignment-id').value = '';
    
    // Reset dropdowns to initial state
    const facultySelect = document.getElementById('faculty-select');
    const courseSelect = document.getElementById('course-select');
    
    facultySelect.innerHTML = '<option value="">Select Department First</option>';
    facultySelect.disabled = true;
    
    courseSelect.innerHTML = '<option value="">Select Department First</option>';
    courseSelect.disabled = true;
}

function closeAssignModal() {
    document.getElementById('assignmentModal').classList.add('hidden');
    document.getElementById('assignmentModal').classList.remove('flex');
}

function editAssignment(id) {
    const assignment = assignmentsData.find(a => a.id === id);
    if (assignment) {
        document.getElementById('assignmentModal').classList.remove('hidden');
        document.getElementById('assignmentModal').classList.add('flex');
        document.getElementById('modal-title').textContent = 'Edit Assignment';
        document.getElementById('save-btn-text').textContent = 'Update Assignment';
        
        document.getElementById('assignment-id').value = assignment.id;
        document.getElementById('faculty-select').value = assignment.faculty_id;
        document.getElementById('department-select').value = assignment.course.department_id;
        
        // Trigger department change to load courses
        updateCourseOptions();
        
        setTimeout(() => {
            document.getElementById('course-select').value = assignment.course_id;
        }, 100);
        
        document.getElementById('semester-select').value = assignment.semester;
        document.getElementById('year-select').value = assignment.year;
    }
}

function deleteAssignment(id) {
    if (confirm('Are you sure you want to delete this assignment?')) {
        fetch(`/admin/course-assignments/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting assignment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting assignment');
        });
    }
}

function saveAssignment() {
    const form = document.getElementById('assignment-form');
    const formData = new FormData(form);
    const id = document.getElementById('assignment-id').value;
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const url = id ? `/admin/course-assignments/${id}` : '/admin/course-assignments';
    
    if (id) {
        formData.append('_method', 'PUT');
    }
    
    // Disable the save button during request
    const saveBtn = document.getElementById('save-btn-text');
    const originalText = saveBtn.textContent;
    saveBtn.textContent = 'Saving...';
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Response status:', response.status);
                console.error('Response text:', text);
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Assignment saved successfully!');
            closeAssignModal();
            location.reload();
        } else {
            const errorMsg = data.error || data.message || 'Unknown error occurred';
            alert('Error saving assignment: ' + errorMsg);
            saveBtn.textContent = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving assignment: ' + error.message);
        saveBtn.textContent = originalText;
    });
}

// Update course options based on selected department
function updateCourseOptions() {
    const departmentId = document.getElementById('department-select').value;
    const courseSelect = document.getElementById('course-select');
    
    if (!departmentId) {
        courseSelect.innerHTML = '<option value="">Select Department First</option>';
        courseSelect.disabled = true;
        return;
    }
    
    courseSelect.innerHTML = '<option value="">Loading courses...</option>';
    courseSelect.disabled = true;
    
    const url = `/admin/course-assignments/courses-by-department?department_id=${departmentId}`;
    
    fetch(url, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(courses => {
        courseSelect.innerHTML = '<option value="">Select Course</option>';
        courses.forEach(course => {
            const option = document.createElement('option');
            option.value = course.id;
            option.textContent = `${course.course_code} - ${course.course_name}`;
            courseSelect.appendChild(option);
        });
        courseSelect.disabled = false;
    })
    .catch(error => {
        console.error('Error loading courses:', error);
        courseSelect.innerHTML = '<option value="">Error loading courses</option>';
        courseSelect.disabled = false;
    });
}

// Update faculty options based on selected department
function updateFacultyOptions() {
    const departmentId = document.getElementById('department-select').value;
    const facultySelect = document.getElementById('faculty-select');
    
    if (!departmentId) {
        facultySelect.innerHTML = '<option value="">Select Department First</option>';
        facultySelect.disabled = true;
        return;
    }
    
    facultySelect.innerHTML = '<option value="">Loading faculty...</option>';
    facultySelect.disabled = true;
    
    const url = `/admin/course-assignments/faculties-by-department?department_id=${departmentId}`;
    
    fetch(url, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(faculties => {
        facultySelect.innerHTML = '<option value="">Select Faculty</option>';
        faculties.forEach(faculty => {
            const option = document.createElement('option');
            option.value = faculty.id;
            option.textContent = `${faculty.name} (${faculty.email})`;
            facultySelect.appendChild(option);
        });
        facultySelect.disabled = false;
    })
    .catch(error => {
        console.error('Error loading faculties:', error);
        facultySelect.innerHTML = '<option value="">Error loading faculties</option>';
        facultySelect.disabled = false;
    });
}

// Filter functions
function applyFilters() {
    const departmentFilter = document.getElementById('department-filter').value;
    const semesterFilter = document.getElementById('semester-filter').value;
    const yearFilter = document.getElementById('year-filter').value;
    
    // Here you would typically make an AJAX request to filter the data
    // For now, we'll just reload with query parameters
    const params = new URLSearchParams();
    if (departmentFilter) params.append('department', departmentFilter);
    if (semesterFilter) params.append('semester', semesterFilter);
    if (yearFilter) params.append('year', yearFilter);
    
    window.location.search = params.toString();
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Department change event - update both courses and faculty
    document.getElementById('department-select').addEventListener('change', function() {
        updateCourseOptions();
        updateFacultyOptions();
    });
    
    // Close modal when clicking outside
    document.getElementById('assignmentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAssignModal();
        }
    });
    
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAssignModal();
        }
    });
});
</script>
@endsection
