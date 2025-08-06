<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->course_code }} - Course Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        .sidebar-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .dark .sidebar-bg {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        .sidebar-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 4px;
        }
        .sidebar-item:hover {
            background: rgba(14, 165, 233, 0.1);
            transform: translateX(4px);
        }
        .sidebar-item.active {
            background: rgba(14, 165, 233, 0.15);
            color: #0ea5e9;
            font-weight: 600;
        }
        .resource-card {
            transition: all 0.3s ease;
        }
        .resource-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .grade-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 1rem;
            font-weight: 600;
        }
        .grade-a { background-color: #dcfce7; color: #166534; }
        .grade-b { background-color: #dbeafe; color: #1d4ed8; }
        .grade-c { background-color: #fef3c7; color: #92400e; }
        .grade-d { background-color: #fed7d7; color: #c53030; }
        .grade-f { background-color: #fecaca; color: #dc2626; }
        .grade-pending { background-color: #f3f4f6; color: #6b7280; }
        
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            background-color: #ccc;
            border-radius: 34px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .toggle-switch.active {
            background-color: #0ea5e9;
        }
        .toggle-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }
        .toggle-switch.active .toggle-slider {
            transform: translateX(20px);
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            z-index: 30;
            transform: translateX(-100%);
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar.active {
            transform: translateX(0);
        }
        
        .sidebar.minimized {
            width: 70px;
        }
        
        .sidebar.minimized .sidebar-text {
            display: none;
        }
        
        .sidebar.minimized .sidebar-header h2,
        .sidebar.minimized .sidebar-header p {
            display: none;
        }
        
        .sidebar.minimized .sidebar-item {
            justify-content: center;
            padding: 0.75rem;
        }
        
        .sidebar.minimized .toggle-switch {
            display: none;
        }
        
        .sidebar-header {
            position: sticky;
            top: 0;
            background: inherit;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            z-index: 10;
        }
        
        .main-content {
            margin-left: 0;
            padding-top: 80px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .main-content.sidebar-expanded {
            margin-left: 280px;
        }
        
        .main-content.sidebar-minimized {
            margin-left: 70px;
        }
        
        .navbar-brand {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            background: rgba(14, 165, 233, 0.9);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            background: rgba(14, 165, 233, 1);
            transform: scale(1.05);
        }
        
        /* Desktop Styles */
        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 280px;
            }
            
            .main-content.sidebar-minimized {
                margin-left: 70px;
            }
            
            .navbar-brand {
                position: relative;
                top: auto;
                left: auto;
                background: rgba(255, 255, 255, 0.2);
            }
        }
        
        /* Mobile Styles */
        @media (max-width: 1023px) {
            .sidebar {
                width: 100%;
                max-width: 320px;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 25;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            
            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }
            
            .main-content {
                margin-left: 0;
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        /* Dark mode styles */
        .dark {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }
        
        .dark .sidebar-bg {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        }
        
        .dark .bg-white {
            background-color: #1e293b !important;
            border-color: #374151 !important;
        }
        
        .dark .bg-gray-50 {
            background-color: #111827 !important;
        }
        
        .dark .bg-gray-100 {
            background-color: #1f2937 !important;
        }
        
        .dark .text-gray-900 {
            color: #f1f5f9 !important;
        }
        
        .dark .text-gray-800 {
            color: #f1f5f9 !important;
        }
        
        .dark .text-gray-700 {
            color: #e2e8f0 !important;
        }
        
        .dark .text-gray-600 {
            color: #cbd5e1 !important;
        }
        
        .dark .sidebar-header {
            border-bottom-color: #374151 !important;
        }
        
        .dark .resource-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg fixed w-full top-0 z-40">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button onclick="toggleSidebar()" class="lg:hidden text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/20">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="navbar-brand lg:bg-white/20 flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-xl"></i>
                        <span>Academic Hub</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('courses.my-courses') }}" class="text-white/90 hover:text-white transition-colors text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to My Courses
                    </a>
                    <div class="text-white/90 text-sm">
                        <i class="fas fa-user mr-2"></i>
                        {{ $user->name ?? 'Test User' }}
                        <span class="bg-white/20 px-2 py-1 rounded text-xs ml-2">
                            {{ ucfirst($user->role ?? 'student') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar sidebar-bg">
        <div class="sidebar-header">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Academic Hub</h2>
                        <p class="text-sm text-gray-600">{{ ucfirst($user->role ?? 'student') }} Panel</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="toggleSidebarSize()" class="hidden lg:block text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-left" id="toggleIcon"></i>
                    </button>
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                    <i class="fas fa-home text-lg"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                
                @if(($user->role ?? 'student') === 'student')
                    <a href="{{ route('courses.my-courses') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-book text-lg"></i>
                        <span class="sidebar-text">My Courses</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-chart-line text-lg"></i>
                        <span class="sidebar-text">Grades</span>
                    </a>
                    <a href="{{ route('faculty-reviews.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-star text-lg"></i>
                        <span class="sidebar-text">Rate Faculty</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-download text-lg"></i>
                        <span class="sidebar-text">Resources</span>
                    </a>
                @endif
                
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3" onclick="toggleNightMode()">
                        <i class="fas fa-moon text-lg"></i>
                        <span class="sidebar-text">Dark Mode</span>
                        <div class="toggle-switch ml-auto" id="nightModeToggle">
                            <div class="toggle-slider"></div>
                        </div>
                    </a>
                    <a href="{{ route('settings') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-cog text-lg"></i>
                        <span class="sidebar-text">Settings</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-question-circle text-lg"></i>
                        <span class="sidebar-text">Help & Support</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container mx-auto px-4 lg:px-6 py-8">
            <!-- Course Header -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="gradient-bg p-8 text-white">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold mb-2">{{ $course->course_code }}</h1>
                            <p class="text-xl mb-4">{{ $course->course_name }}</p>
                            <div class="flex flex-wrap items-center gap-4">
                                <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $course->course_type }}
                                </span>
                                <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-credit-card mr-1"></i>
                                    {{ $course->credits }} Credits
                                </span>
                                <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Level {{ $course->level }} - Term {{ $course->term }}
                                </span>
                            </div>
                        </div>
                        @if($studentCourse && $studentCourse->grade)
                            @php
                                $gradeClass = 'grade-' . strtolower(substr($studentCourse->grade, 0, 1));
                            @endphp
                            <div class="mt-6 lg:mt-0 lg:ml-8">
                                <div class="bg-white/20 rounded-xl p-6 text-center">
                                    <div class="grade-badge {{ $gradeClass }} text-2xl mb-2">
                                        {{ $studentCourse->grade }}
                                    </div>
                                    <div class="text-sm">Current Grade</div>
                                    <div class="text-xs mt-1">{{ number_format($studentCourse->grade_point, 2) }} GP</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Course Information & Grade Management -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Grade Management Section -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Grade Management</h3>
                        
                        <form method="POST" action="{{ route('courses.update-grade', $course) }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Grade</label>
                                    <select name="grade" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Grade</option>
                                        <option value="A+" {{ $studentCourse && $studentCourse->grade === 'A+' ? 'selected' : '' }}>A+ (4.00)</option>
                                        <option value="A" {{ $studentCourse && $studentCourse->grade === 'A' ? 'selected' : '' }}>A (3.75)</option>
                                        <option value="A-" {{ $studentCourse && $studentCourse->grade === 'A-' ? 'selected' : '' }}>A- (3.50)</option>
                                        <option value="B+" {{ $studentCourse && $studentCourse->grade === 'B+' ? 'selected' : '' }}>B+ (3.25)</option>
                                        <option value="B" {{ $studentCourse && $studentCourse->grade === 'B' ? 'selected' : '' }}>B (3.00)</option>
                                        <option value="B-" {{ $studentCourse && $studentCourse->grade === 'B-' ? 'selected' : '' }}>B- (2.75)</option>
                                        <option value="C+" {{ $studentCourse && $studentCourse->grade === 'C+' ? 'selected' : '' }}>C+ (2.50)</option>
                                        <option value="C" {{ $studentCourse && $studentCourse->grade === 'C' ? 'selected' : '' }}>C (2.25)</option>
                                        <option value="C-" {{ $studentCourse && $studentCourse->grade === 'C-' ? 'selected' : '' }}>C- (2.00)</option>
                                        <option value="D+" {{ $studentCourse && $studentCourse->grade === 'D+' ? 'selected' : '' }}>D+ (1.75)</option>
                                        <option value="D" {{ $studentCourse && $studentCourse->grade === 'D' ? 'selected' : '' }}>D (1.50)</option>
                                        <option value="F" {{ $studentCourse && $studentCourse->grade === 'F' ? 'selected' : '' }}>F (0.00)</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="enrolled" {{ $studentCourse && $studentCourse->status === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                        <option value="completed" {{ $studentCourse && $studentCourse->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="dropped" {{ $studentCourse && $studentCourse->status === 'dropped' ? 'selected' : '' }}>Dropped</option>
                                        <option value="failed" {{ $studentCourse && $studentCourse->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Grade
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Course Details Section -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Course Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Course Details</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Course Code:</span>
                                        <span class="font-medium">{{ $course->course_code }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Credits:</span>
                                        <span class="font-medium">{{ $course->credits }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Type:</span>
                                        <span class="font-medium">{{ $course->course_type }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Level:</span>
                                        <span class="font-medium">{{ $course->level }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Term:</span>
                                        <span class="font-medium">{{ $course->term }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($studentCourse)
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Your Progress</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium capitalize">{{ $studentCourse->status }}</span>
                                    </div>
                                    @if($studentCourse->grade)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Grade:</span>
                                        <span class="font-medium">{{ $studentCourse->grade }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Grade Point:</span>
                                        <span class="font-medium">{{ number_format($studentCourse->grade_point, 2) }}</span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Enrolled:</span>
                                        <span class="font-medium">{{ $studentCourse->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Resources & Actions -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            <button class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-download mr-2"></i>
                                Download Syllabus
                            </button>
                            <button class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-upload mr-2"></i>
                                Upload Assignment
                            </button>
                            <button class="w-full bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-comments mr-2"></i>
                                Discussion Forum
                            </button>
                            <button class="w-full bg-yellow-600 text-white px-4 py-3 rounded-lg hover:bg-yellow-700 transition-colors flex items-center justify-center">
                                <i class="fas fa-star mr-2"></i>
                                Rate Faculty
                            </button>
                        </div>
                    </div>

                    <!-- Course Resources -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Course Resources</h3>
                        
                        <div class="space-y-4">
                            @forelse($resources as $resource)
                            <div class="resource-card border border-gray-200 rounded-lg p-4 hover:border-blue-300">
                                <div class="flex items-start space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-lg">
                                        @if($resource->resource_type === 'pdf')
                                            <i class="fas fa-file-pdf text-red-600"></i>
                                        @elseif($resource->resource_type === 'video')
                                            <i class="fas fa-video text-blue-600"></i>
                                        @elseif($resource->resource_type === 'link')
                                            <i class="fas fa-link text-green-600"></i>
                                        @else
                                            <i class="fas fa-file text-gray-600"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $resource->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $resource->description }}</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-xs text-gray-400">{{ $resource->created_at->format('M d, Y') }}</span>
                                            <button class="text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-folder-open text-4xl mb-3"></i>
                                <p>No resources available yet</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- CGPA Impact -->
                    @if($studentCourse && $studentCourse->grade)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">CGPA Impact</h3>
                        
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">
                                +{{ number_format($studentCourse->grade_point * $course->credits, 2) }}
                            </div>
                            <div class="text-sm text-gray-500">Quality Points</div>
                            <div class="text-xs text-gray-400 mt-1">From this course</div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="text-sm text-gray-600 text-center">
                                This {{ $course->credits }}-credit course contributes<br>
                                <strong>{{ number_format(($studentCourse->grade_point * $course->credits) / 144 * 100, 1) }}%</strong> to your overall CGPA
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let isMinimized = false;
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('active');
            
            if (window.innerWidth < 1024) {
                overlay.classList.toggle('active');
            }
        }
        
        function toggleSidebarSize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = document.getElementById('toggleIcon');
            
            isMinimized = !isMinimized;
            
            if (isMinimized) {
                sidebar.classList.add('minimized');
                mainContent.classList.remove('sidebar-expanded');
                mainContent.classList.add('sidebar-minimized');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            } else {
                sidebar.classList.remove('minimized');
                mainContent.classList.remove('sidebar-minimized');
                mainContent.classList.add('sidebar-expanded');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
            
            localStorage.setItem('sidebarMinimized', isMinimized);
        }

        function toggleNightMode() {
            const toggle = document.getElementById('nightModeToggle');
            const body = document.body;
            
            toggle.classList.toggle('active');
            body.classList.toggle('dark');
            
            const isDark = body.classList.contains('dark');
            localStorage.setItem('nightMode', isDark);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const nightMode = localStorage.getItem('nightMode');
            if (nightMode === 'true') {
                document.body.classList.add('dark');
                document.getElementById('nightModeToggle').classList.add('active');
            }
            
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const sidebarMinimized = localStorage.getItem('sidebarMinimized');
                
                if (sidebarMinimized === 'true') {
                    isMinimized = true;
                    sidebar.classList.add('minimized');
                    mainContent.classList.add('sidebar-minimized');
                    document.getElementById('toggleIcon').classList.remove('fa-chevron-left');
                    document.getElementById('toggleIcon').classList.add('fa-chevron-right');
                } else {
                    mainContent.classList.add('sidebar-expanded');
                }
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleButton = event.target.closest('button[onclick="toggleSidebar()"]');
            
            if (!sidebar.contains(event.target) && !toggleButton && window.innerWidth < 1024) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                
                if (isMinimized) {
                    mainContent.classList.remove('sidebar-expanded');
                    mainContent.classList.add('sidebar-minimized');
                } else {
                    mainContent.classList.remove('sidebar-minimized');
                    mainContent.classList.add('sidebar-expanded');
                }
            } else {
                mainContent.classList.remove('sidebar-expanded', 'sidebar-minimized');
            }
        });
    </script>
</body>
</html>
