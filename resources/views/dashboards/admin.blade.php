@extends('layouts.admin')

@section('title', 'Admin Dashboard - Academic Hub')

@section('admin-content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, {{ $user->name }}!</h1>
    <p class="text-gray-600">Here's what's happening in your academic hub today.</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-600 text-sm">
                <i class="fas fa-arrow-up"></i> 12% from last month
            </span>
        </div>
    </div>
    
    <!-- Total Students -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Students</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-user-graduate text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-green-600 text-sm">
                <i class="fas fa-arrow-up"></i> 8% from last month
            </span>
        </div>
    </div>
    
    <!-- Total Faculty -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Faculty</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_faculty'] }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-blue-600 text-sm">
                <i class="fas fa-arrow-up"></i> 3% from last month
            </span>
        </div>
    </div>
    
    <!-- Pending Reviews -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pending Reviews</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_reviews'] }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-red-600 text-sm">
                <i class="fas fa-arrow-down"></i> 5% from last week
            </span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Quick Actions Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.course-assignments.index') }}" 
               class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                <i class="fas fa-chalkboard-teacher text-blue-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-blue-800">Assign Teachers</span>
            </a>
            
            <a href="#users" 
               class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                <i class="fas fa-user-plus text-green-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-green-800">Add User</span>
            </a>
            
            <a href="#courses" 
               class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                <i class="fas fa-book-open text-purple-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-purple-800">Add Course</span>
            </a>
            
            <a href="#reports" 
               class="flex flex-col items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors group">
                <i class="fas fa-chart-bar text-yellow-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-yellow-800">View Reports</span>
            </a>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">New faculty member registered</p>
                    <p class="text-xs text-gray-500">2 hours ago</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Course assignment updated</p>
                    <p class="text-xs text-gray-500">4 hours ago</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">New faculty review submitted</p>
                    <p class="text-xs text-gray-500">6 hours ago</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Resource uploaded to CSE-101</p>
                    <p class="text-xs text-gray-500">8 hours ago</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Assignments -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Teacher Assignments</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dr. John Smith</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CSE101 - Intro to Programming</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Computer Science</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Spring 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dr. Sarah Johnson</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CSE102 - Data Structures</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Computer Science</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Spring 2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('admin.course-assignments.index') }}" 
           class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
            View All Assignments →
        </a>
    </div>
</div>
@endsection
