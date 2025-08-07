<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Academic Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            z-index: 30;
            transition: all 0.3s ease;
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-bg {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid #e2e8f0;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .sidebar-item i {
            width: 20px;
            text-align: center;
            margin-right: 0.75rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* Sidebar overlay for mobile */
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

        /* Minimized sidebar */
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

        /* Desktop styles */
        @media (min-width: 1024px) {
            .sidebar {
                position: fixed;
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 280px;
            }
            
            .main-content.sidebar-minimized {
                margin-left: 70px;
            }
        }

        /* Toggle switch for dark mode */
        .toggle-switch {
            width: 44px;
            height: 24px;
            background: #ccc;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            transition: background 0.3s;
        }

        .toggle-switch.active {
            background: #667eea;
        }

        .toggle-slider {
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.3s;
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(20px);
        }

        /* Footer margin utilities */
        .footer-margin {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        .footer-margin.sidebar-expanded {
            margin-left: 280px;
        }

        .footer-margin.sidebar-minimized {
            margin-left: 70px;
        }

        /* Mobile footer adjustment */
        @media (max-width: 1023px) {
            .footer-margin {
                margin-left: 0 !important;
            }
            
            .footer-margin.sidebar-expanded,
            .footer-margin.sidebar-minimized {
                margin-left: 0 !important;
            }
        }

        /* Course specific styles */
        .course-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-left-color: #0ea5e9;
        }
        .grade-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .grade-a { background-color: #dcfce7; color: #166534; }
        .grade-b { background-color: #dbeafe; color: #1d4ed8; }
        .grade-c { background-color: #fef3c7; color: #92400e; }
        .grade-d { background-color: #fed7d7; color: #c53030; }
        .grade-f { background-color: #fecaca; color: #dc2626; }
        .grade-pending { background-color: #f3f4f6; color: #6b7280; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md relative z-40 lg:hidden">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-800 p-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800">Academic Hub</h1>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 hidden sm:block">
                        {{ $user->name ?? 'Student' }}
                    </span>
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-bold">
                            {{ strtoupper(substr($user->name ?? 'S', 0, 1)) }}
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
                        <h2 class="text-lg font-bold text-white">Academic Hub</h2>
                        <p class="text-sm text-blue-100">{{ ucfirst($user->role ?? 'student') }} Panel</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="toggleSidebarSize()" class="hidden lg:block text-blue-100 hover:text-white p-2 rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-chevron-left" id="toggleIcon"></i>
                    </button>
                    <button onclick="toggleSidebar()" class="lg:hidden text-blue-100 hover:text-white p-2 rounded-lg hover:bg-blue-600">
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
                    <a href="{{ route('grades.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-chart-line text-lg"></i>
                        <span class="sidebar-text">Grades</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-star text-lg"></i>
                        <span class="sidebar-text">Rate Faculty</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-download text-lg"></i>
                        <span class="sidebar-text">Resources</span>
                    </a>
                @elseif(($user->role ?? 'student') === 'faculty')
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-chalkboard-teacher text-lg"></i>
                        <span class="sidebar-text">My Classes</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-users text-lg"></i>
                        <span class="sidebar-text">Students</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-file-alt text-lg"></i>
                        <span class="sidebar-text">Resources</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-comments text-lg"></i>
                        <span class="sidebar-text">Reviews</span>
                    </a>
                @elseif(($user->role ?? 'student') === 'admin')
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-users-cog text-lg"></i>
                        <span class="sidebar-text">Manage Users</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-building text-lg"></i>
                        <span class="sidebar-text">Departments</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-graduation-cap text-lg"></i>
                        <span class="sidebar-text">Courses</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-chart-bar text-lg"></i>
                        <span class="sidebar-text">Analytics</span>
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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-item flex items-center space-x-3 px-4 py-3 w-full text-left text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                            <span class="sidebar-text">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container mx-auto px-4 lg:px-6 py-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Courses</h1>
                <p class="text-gray-600">Manage your enrolled courses and track your academic progress</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-book text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ collect($coursesBySemester)->sum(function($courses) { return $courses->count(); }) }}
                            </div>
                            <div class="text-sm text-gray-500">Total Courses</div>
                        </div>
                    </div>
                </div>

                <!-- Completed Courses -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ collect($coursesBySemester)->flatten()->where('status', 'completed')->count() }}
                            </div>
                            <div class="text-sm text-gray-500">Completed</div>
                        </div>
                    </div>
                </div>

                <!-- Enrolled Courses -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ collect($coursesBySemester)->flatten()->where('status', 'enrolled')->count() }}
                            </div>
                            <div class="text-sm text-gray-500">In Progress</div>
                        </div>
                    </div>
                </div>

                <!-- Current CGPA -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ number_format($cgpa, 2) }}
                            </div>
                            <div class="text-sm text-gray-500">Current CGPA</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses by Semester -->
            @forelse($coursesBySemester as $semesterName => $courses)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold">{{ $semesterName }}</h3>
                                <p class="text-blue-100">{{ $courses->count() }} courses</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold">
                                    {{ $semesterGPAs[$semesterName] ?? '0.00' }}
                                </div>
                                <div class="text-blue-100">Semester GPA</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($courses as $studentCourse)
                                <div class="course-card bg-gray-50 rounded-lg p-6 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h4 class="font-bold text-lg text-gray-900">{{ $studentCourse->course->course_code }}</h4>
                                            <p class="text-sm text-gray-600 mb-2">{{ $studentCourse->course->course_name }}</p>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span><i class="fas fa-credit-card mr-1"></i>{{ $studentCourse->course->credits }} Credits</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($studentCourse->grade)
                                                <span class="grade-badge grade-{{ strtolower(substr($studentCourse->grade, 0, 1)) }}">
                                                    {{ $studentCourse->grade }}
                                                </span>
                                            @else
                                                <span class="grade-badge grade-pending">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($studentCourse->status === 'completed') bg-green-100 text-green-800
                                                @elseif($studentCourse->status === 'enrolled') bg-blue-100 text-blue-800
                                                @elseif($studentCourse->status === 'dropped') bg-gray-100 text-gray-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($studentCourse->status) }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('courses.show', $studentCourse->course) }}" 
                                               class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <i class="fas fa-book text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Courses Found</h3>
                    <p class="text-gray-500 mb-6">You haven't enrolled in any courses yet.</p>
                    <a href="{{ route('dashboard') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Explore Courses
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16 footer-margin" id="footer">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-blue-400 text-2xl"></i>
                        <h3 class="text-xl font-bold">Academic Hub</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed">
                        Revolutionizing university education through innovative technology solutions for students, faculty, and administrators.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-white">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('courses.my-courses') }}" class="text-gray-300 hover:text-white transition-colors">My Courses</a></li>
                        <li><a href="{{ route('grades.index') }}" class="text-gray-300 hover:text-white transition-colors">Grades</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">CGPA Tracker</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Help & Support</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-white">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Course Management</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Grade Tracking</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Faculty Rating</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Resource Sharing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Academic Analytics</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-white">Contact Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt text-blue-400"></i>
                            <span class="text-gray-300">Dhanmondi, Dhaka, Bangladesh</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-400"></i>
                            <span class="text-gray-300">+880 1XXX-XXXXXX</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-blue-400"></i>
                            <span class="text-gray-300">info@academichub.edu</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-globe text-blue-400"></i>
                            <span class="text-gray-300">www.academichub.edu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-gray-400 text-sm">
                        &copy; 2025 Academic Hub. All rights reserved. Made with ❤️ by <span class="text-blue-400 font-semibold">blackSquad</span>
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        let isMinimized = false;
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth < 1024) {
                // Mobile behavior
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            }
        }

        function toggleSidebarSize() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                const toggleIcon = document.getElementById('toggleIcon');
                
                isMinimized = !isMinimized;
                
                if (isMinimized) {
                    sidebar.classList.add('minimized');
                    mainContent.classList.remove('sidebar-expanded');
                    mainContent.classList.add('sidebar-minimized');
                    footer.classList.remove('sidebar-expanded');
                    footer.classList.add('sidebar-minimized');
                    toggleIcon.classList.remove('fa-chevron-left');
                    toggleIcon.classList.add('fa-chevron-right');
                } else {
                    sidebar.classList.remove('minimized');
                    mainContent.classList.remove('sidebar-minimized');
                    mainContent.classList.add('sidebar-expanded');
                    footer.classList.remove('sidebar-minimized');
                    footer.classList.add('sidebar-expanded');
                    toggleIcon.classList.remove('fa-chevron-right');
                    toggleIcon.classList.add('fa-chevron-left');
                }
            } else {
                // Reset classes for mobile
                mainContent.classList.remove('sidebar-expanded', 'sidebar-minimized');
                footer.classList.remove('sidebar-expanded', 'sidebar-minimized');
            }
        }

        function toggleNightMode() {
            const toggle = document.getElementById('nightModeToggle');
            toggle.classList.toggle('active');
            console.log('Night mode toggled');
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const mainContent = document.getElementById('mainContent');
            const footer = document.getElementById('footer');
            
            if (window.innerWidth >= 1024) {
                // Desktop: Show sidebar, hide overlay
                overlay.classList.remove('active');
                if (isMinimized) {
                    mainContent.classList.remove('sidebar-expanded');
                    mainContent.classList.add('sidebar-minimized');
                    footer.classList.remove('sidebar-expanded');
                    footer.classList.add('sidebar-minimized');
                } else {
                    mainContent.classList.remove('sidebar-minimized');
                    mainContent.classList.add('sidebar-expanded');
                    footer.classList.remove('sidebar-minimized');
                    footer.classList.add('sidebar-expanded');
                }
            } else {
                // Reset classes for mobile
                mainContent.classList.remove('sidebar-expanded', 'sidebar-minimized');
                footer.classList.remove('sidebar-expanded', 'sidebar-minimized');
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state for desktop
            if (window.innerWidth >= 1024) {
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                mainContent.classList.add('sidebar-expanded');
                footer.classList.add('sidebar-expanded');
            }
        });
    </script>
</body>
</html>
