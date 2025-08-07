<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades - Academic Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        .sidebar-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
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
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
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
        .dark .bg-gray-200 {
            background-color: #374151 !important;
        }
        .dark .bg-gray-900 {
            background-color: #000000 !important;
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
        .dark .text-gray-500 {
            color: #9ca3af !important;
        }
        .dark .text-gray-400 {
            color: #9ca3af !important;
        }
        .dark .text-gray-300 {
            color: #d1d5db !important;
        }
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        .dark .border-gray-300 {
            border-color: #4b5563 !important;
        }
        .dark .border-gray-800 {
            border-color: #1f2937 !important;
        }
        .dark .hover\:bg-gray-100:hover {
            background-color: #374151 !important;
        }
        .dark .bg-blue-100 {
            background-color: #1e40af !important;
        }
        .dark .text-blue-600 {
            color: #60a5fa !important;
        }
        .dark .text-blue-400 {
            color: #60a5fa !important;
        }
        .dark .hover\:text-blue-400:hover {
            color: #93c5fd !important;
        }
        .dark .hover\:text-white:hover {
            color: #ffffff !important;
        }
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.3) !important;
        }
        .dark .sidebar-header {
            border-bottom-color: #374151 !important;
        }
        .dark .card-hover:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.4) !important;
        }
        .dark .bg-blue-50 {
            background-color: #1e3a8a !important;
        }
        .dark .bg-purple-50 {
            background-color: #581c87 !important;
        }
        .dark .bg-green-50 {
            background-color: #14532d !important;
        }
        .dark .bg-yellow-50 {
            background-color: #713f12 !important;
        }
        .dark .text-blue-900 {
            color: #dbeafe !important;
        }
        .dark .text-purple-900 {
            color: #e9d5ff !important;
        }
        .dark .text-green-900 {
            color: #dcfce7 !important;
        }
        .dark .text-yellow-900 {
            color: #fef3c7 !important;
        }
        .dark .text-blue-800 {
            color: #bfdbfe !important;
        }
        .dark .text-purple-800 {
            color: #ddd6fe !important;
        }
        .dark .text-green-800 {
            color: #bbf7d0 !important;
        }
        .dark .text-yellow-800 {
            color: #fde68a !important;
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
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 80px; /* Start below the navbar */
            left: 0;
            height: calc(100vh - 80px); /* Adjust height to account for navbar */
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
        
        .dark .sidebar-header {
            border-bottom-color: #374151;
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
                top: 80px; /* Account for navbar */
                height: calc(100vh - 80px);
            }
            
            .main-content {
                margin-left: 280px;
                padding-top: 80px; /* Account for navbar */
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
                    <a href="#" class="navbar-brand lg:bg-white/20 flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-xl"></i>
                        <span>Academic Hub</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
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
                        <i class="fas fa-user text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $user->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-600">{{ ucfirst($user->role ?? 'student') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="toggleSidebarSize()" class="hidden lg:flex items-center justify-center w-8 h-8 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors border border-gray-300">
                        <i class="fas fa-chevron-left text-sm" id="toggleIcon"></i>
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
                    <a href="{{ route('courses.my-courses') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-book text-lg"></i>
                        <span class="sidebar-text">My Courses</span>
                    </a>
                    <a href="{{ route('grades.index') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3">
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
                    <a href="#" class="sidebar-item flex items-center justify-between px-4 py-3" onclick="toggleNightMode()">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-moon text-lg"></i>
                            <span class="sidebar-text">Dark Mode</span>
                        </div>
                        <div class="toggle-switch" id="nightModeToggle">
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
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">My Grades</h1>
                <p class="text-gray-600">Track your academic performance and CGPA</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Overall CGPA -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-trophy text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Overall CGPA</p>
                            <p class="text-2xl font-bold text-gray-900" id="overallCgpa">{{ number_format($overallCgpa ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Credits -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Credits</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCredits ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Current Semester -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="fas fa-calendar text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Current Semester</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $currentSemester ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grades Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Course Grades</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($grades ?? [] as $grade)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $grade->course->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $grade->course->code ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $grade->course->credits ?? 0 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($grade->grade >= 4.0) bg-green-100 text-green-800
                                        @elseif($grade->grade >= 3.0) bg-blue-100 text-blue-800
                                        @elseif($grade->grade >= 2.0) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $grade->letter_grade ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($grade->grade ?? 0, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $grade->semester ?? 'N/A' }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No grades available
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 footer-margin" id="footer">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600">&copy; 2024 Academic Hub. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        let isMinimized = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function toggleSidebarSize() {
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
            
            // Save preference
            localStorage.setItem('sidebarMinimized', isMinimized);
        }

        function toggleNightMode() {
            const toggle = document.getElementById('nightModeToggle');
            const body = document.body;
            
            toggle.classList.toggle('active');
            body.classList.toggle('dark');
            
            // Save preference to localStorage
            const isDark = body.classList.contains('dark');
            localStorage.setItem('nightMode', isDark);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize night mode
            const nightMode = localStorage.getItem('nightMode');
            if (nightMode === 'true') {
                document.body.classList.add('dark');
                document.getElementById('nightModeToggle').classList.add('active');
            }
            
            // Initialize sidebar state on desktop
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                const sidebarMinimized = localStorage.getItem('sidebarMinimized');
                
                if (sidebarMinimized === 'true') {
                    isMinimized = true;
                    sidebar.classList.add('minimized');
                    mainContent.classList.add('sidebar-minimized');
                    footer.classList.add('sidebar-minimized');
                    document.getElementById('toggleIcon').classList.remove('fa-chevron-left');
                    document.getElementById('toggleIcon').classList.add('fa-chevron-right');
                } else {
                    mainContent.classList.add('sidebar-expanded');
                    footer.classList.add('sidebar-expanded');
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
            const footer = document.getElementById('footer');
            
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                
                // Apply desktop sidebar state
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

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add active state to current page links
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-item').forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
