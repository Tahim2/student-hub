<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CGPA Tracker - Academic Hub</title>
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
            border-bottom-color: #374151;
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
                <div class="flex items-center">
                    <!-- Desktop Sidebar Toggle (shows only on large screens) -->
                    <button onclick="toggleSidebar()" class="hidden lg:block text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/20 mr-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="navbar-brand lg:bg-white/20 flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-xl"></i>
                        <span>Academic Hub</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <!-- Mobile Menu Button - ONLY shows on small screens - moved to right side -->
                    <button onclick="toggleMobileMenu()" class="sm:block md:block lg:hidden xl:hidden text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/20 mr-2 border-2 border-white/50">
                        <i class="fas fa-bars text-xl" id="mobile-menu-icon"></i>
                    </button>
                    <a href="{{ route('profile') ?? '#' }}" class="flex items-center text-white/90 hover:text-white transition-colors group">
                        @if($user->profile_picture ?? null)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white/20 group-hover:border-white/40 transition-colors object-cover">
                        @else
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/20 group-hover:border-white/40 transition-colors">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                        @endif
                    </a>
                </div>
            </div>
            
            <!-- Mobile Menu Dropdown - ONLY shows on small screens -->
            <div id="mobile-menu" class="lg:hidden hidden absolute top-full right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-xl z-50 max-h-96 overflow-y-auto">
                <div class="py-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-home w-5 text-center mr-3 text-blue-600 dark:text-blue-400"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    @if(($user->role ?? 'student') === 'student')
                        <a href="{{ route('courses.my-courses') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-book w-5 text-center mr-3 text-green-600 dark:text-green-400"></i>
                            <span>My Courses</span>
                        </a>
                        <a href="{{ route('grades.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chart-line w-5 text-center mr-3 text-purple-600 dark:text-purple-400"></i>
                            <span>CGPA Tracker</span>
                        </a>
                        <a href="{{ route('faculty-reviews.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-star w-5 text-center mr-3 text-yellow-600 dark:text-yellow-400"></i>
                            <span>Rate Faculty</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-download w-5 text-center mr-3 text-indigo-600 dark:text-indigo-400"></i>
                            <span>Resources</span>
                        </a>
                    @elseif(($user->role ?? 'student') === 'faculty')
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chalkboard-teacher w-5 text-center mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>My Classes</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users w-5 text-center mr-3 text-green-600 dark:text-green-400"></i>
                            <span>Students</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-file-alt w-5 text-center mr-3 text-purple-600 dark:text-purple-400"></i>
                            <span>Resources</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-comments w-5 text-center mr-3 text-orange-600 dark:text-orange-400"></i>
                            <span>Reviews</span>
                        </a>
                    @elseif(($user->role ?? 'student') === 'admin')
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-users-cog w-5 text-center mr-3 text-red-600 dark:text-red-400"></i>
                            <span>Manage Users</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-building w-5 text-center mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>Departments</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-graduation-cap w-5 text-center mr-3 text-green-600 dark:text-green-400"></i>
                            <span>Courses</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chart-bar w-5 text-center mr-3 text-purple-600 dark:text-purple-400"></i>
                            <span>Analytics</span>
                        </a>
                    @endif
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 mt-2 pt-2">
                        <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-user w-5 text-center mr-3 text-blue-600 dark:text-blue-400"></i>
                            <span>Profile</span>
                        </a>
                        <button onclick="toggleNightMode()" class="flex items-center justify-between w-full px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-moon w-5 text-center mr-3 text-indigo-600 dark:text-indigo-400"></i>
                                <span>Dark Mode</span>
                            </div>
                            <div class="toggle-switch" id="mobileNightModeToggle">
                                <div class="toggle-slider"></div>
                            </div>
                        </button>
                        <a href="{{ route('settings') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-cog w-5 text-center mr-3 text-gray-600 dark:text-gray-400"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-question-circle w-5 text-center mr-3 text-yellow-600 dark:text-yellow-400"></i>
                            <span>Help & Support</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>
                                <span>Logout</span>
                            </button>
                        </form>
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
                        <span class="sidebar-text">CGPA Tracker</span>
                    </a>
                    <a href="{{ route('faculty-reviews.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
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
                    <a href="{{ route('profile') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-user text-lg"></i>
                        <span class="sidebar-text">Profile</span>
                    </a>
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
                <h1 class="text-3xl font-bold text-gray-900 mb-4">CGPA Tracker</h1>
                <p class="text-gray-600">Track your academic performance and plan for target CGPA</p>
            </div>

            <!-- CGPA Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Current CGPA -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Current CGPA</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($cgpa ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Credits -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Completed Credits</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCredits ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Remaining Credits -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Remaining Credits</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $remainingCredits ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Progress -->
                <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Current Position</p>
                            <p class="text-lg font-bold text-gray-900">L{{ $currentLevel ?? 1 }} T{{ $currentTerm ?? 1 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Input Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Input Semester Grades</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Level and Term Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Semester</label>
                        <div class="grid grid-cols-2 gap-4">
                            <select id="levelSelect" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Level</option>
                                @php
                                    $uniqueLevels = collect($allSemesters)->pluck('level')->unique()->sort();
                                @endphp
                                @foreach($uniqueLevels as $level)
                                    <option value="{{ $level }}">Level {{ $level }}</option>
                                @endforeach
                            </select>
                            <select id="termSelect" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" disabled>
                                <option value="">Select Term</option>
                                <option value="1">Term 1</option>
                                <option value="2">Term 2</option>
                                <option value="3">Term 3</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Load Courses Button -->
                    <div class="flex items-end">
                        <button id="loadCoursesBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors" disabled>
                            Load Courses
                        </button>
                    </div>
                </div>
                
                <!-- Courses Table -->
                <div id="coursesContainer" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Credits</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Points</th>
                                </tr>
                            </thead>
                            <tbody id="coursesTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Courses will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <span id="semesterCredits" class="font-medium">Total Credits: 0</span> | 
                            <span id="semesterGPA" class="font-medium">Semester GPA: 0.00</span>
                        </div>
                        <button id="saveGradesBtn" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                            Save Grades
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cumulative Academic Summary -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">📊 Cumulative Academic Summary</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Overall CGPA -->
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                        <div class="text-3xl font-bold mb-2
                            @if($cgpa >= 3.5) text-green-600
                            @elseif($cgpa >= 3.0) text-blue-600
                            @elseif($cgpa >= 2.5) text-yellow-600
                            @else text-red-600
                            @endif">
                            {{ number_format($cgpa, 2) }}
                        </div>
                        <div class="text-sm font-medium text-gray-600">Current CGPA</div>
                        <div class="text-xs text-gray-500 mt-1">
                            @if($cgpa >= 3.75) Excellent
                            @elseif($cgpa >= 3.5) Very Good
                            @elseif($cgpa >= 3.0) Good
                            @elseif($cgpa >= 2.5) Satisfactory
                            @elseif($cgpa > 0) Needs Improvement
                            @else No grades yet
                            @endif
                        </div>
                    </div>
                    
                    <!-- Total Credits -->
                    <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg border border-green-200">
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $totalCredits }}</div>
                        <div class="text-sm font-medium text-gray-600">Credits Completed</div>
                        <div class="text-xs text-gray-500 mt-1">
                            @php $totalRequired = 144; @endphp
                            {{ number_format(($totalCredits / $totalRequired) * 100, 1) }}% of degree
                        </div>
                    </div>
                    
                    <!-- Semesters Completed -->
                    <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                        <div class="text-3xl font-bold text-purple-600 mb-2">
                            {{ collect($allSemesters)->where('status', 'completed')->count() }}
                        </div>
                        <div class="text-sm font-medium text-gray-600">Semesters Done</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ collect($allSemesters)->where('status', 'completed')->count() }} / 12 total
                        </div>
                    </div>
                    
                    <!-- Grade Point Average -->
                    <div class="text-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg border border-orange-200">
                        <div class="text-3xl font-bold text-orange-600 mb-2">{{ number_format($totalGradePoints, 1) }}</div>
                        <div class="text-sm font-medium text-gray-600">Grade Points</div>
                        <div class="text-xs text-gray-500 mt-1">Total earned</div>
                    </div>
                </div>
                
                <!-- Semester-wise GPA Chart -->
                @if(count($semesterGPAs) > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">📈 GPA Progression</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($semesterGPAs as $semesterName => $gpa)
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-sm font-medium text-gray-600 mb-1">{{ $semesterName }}</div>
                            <div class="text-xl font-bold
                                @if($gpa >= 3.5) text-green-600
                                @elseif($gpa >= 3.0) text-blue-600
                                @elseif($gpa >= 2.5) text-yellow-600
                                @else text-red-600
                                @endif">
                                {{ number_format($gpa, 2) }}
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-gradient-to-r 
                                    @if($gpa >= 3.5) from-green-400 to-green-600
                                    @elseif($gpa >= 3.0) from-blue-400 to-blue-600
                                    @elseif($gpa >= 2.5) from-yellow-400 to-yellow-600
                                    @else from-red-400 to-red-600
                                    @endif
                                    h-2 rounded-full transition-all duration-300" 
                                    style="width: {{ ($gpa / 4.0) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Academic Performance Insights -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-medium text-blue-900 mb-3">🎯 Academic Insights</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <strong>Best Semester:</strong> 
                            @if(count($semesterGPAs) > 0)
                                {{ array_keys($semesterGPAs, max($semesterGPAs))[0] ?? 'N/A' }} 
                                ({{ number_format(max($semesterGPAs), 2) }})
                            @else
                                No grades yet
                            @endif
                        </div>
                        <div>
                            <strong>Graduation Progress:</strong> 
                            {{ number_format(($totalCredits / 144) * 100, 1) }}% complete
                        </div>
                        <div>
                            <strong>Honor Status:</strong>
                            @if($cgpa >= 3.75) Dean's List Eligible
                            @elseif($cgpa >= 3.5) Honor Roll Eligible  
                            @elseif($cgpa >= 3.0) Good Standing
                            @else Needs Improvement
                            @endif
                        </div>
                        <div>
                            <strong>Credits Remaining:</strong> 
                            {{ max(0, 144 - $totalCredits) }} credits to graduate
                        </div>
                    </div>
                </div>
            </div>

            <!-- Semester Results Display -->
            @if(!empty($semesterData))
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">📊 Semester Results</h2>
                
                @if(count($semesterData) > 0)
                    <div class="space-y-6">
                        @foreach($semesterData as $semester)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Semester Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $semester['name'] }} {{ $semester['year'] }} (Level {{ $semester['level'] }})
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ count($semester['courses']) }} courses completed</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-blue-600">{{ number_format($semester['gpa'], 2) }}</div>
                                        <div class="text-sm text-gray-600">Semester GPA</div>
                                        <div class="text-sm text-gray-500">{{ $semester['credits'] }} credits</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Courses Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($semester['courses'] as $index => $course)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $course->course->course_code }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $course->course->course_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->course->credits }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    @if(in_array($course->grade, ['A+', 'A', 'A-'])) bg-green-100 text-green-800
                                                    @elseif(in_array($course->grade, ['B+', 'B', 'B-'])) bg-blue-100 text-blue-800
                                                    @elseif(in_array($course->grade, ['C+', 'C', 'C-'])) bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $course->grade }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($course->grade_point, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        
                                        <!-- Summary Row -->
                                        <tr class="bg-blue-50 font-medium">
                                            <td colspan="3" class="px-6 py-4 text-sm text-gray-900">Semester Total</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $semester['credits'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">GPA: {{ number_format($semester['gpa'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($semester['credits'] * $semester['gpa'], 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-5xl mb-4">📋</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Semester Results</h3>
                        <p class="text-gray-500">You haven't uploaded any semester results yet. Use the form above to input your grades.</p>
                    </div>
                @endif
            </div>
            @endif

            <!-- Target CGPA Calculator -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl shadow-lg p-6 mb-8 border border-blue-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-target text-blue-600 mr-2"></i>
                    Target CGPA Calculator
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-blue-800 mb-2">Target CGPA</label>
                        <input type="number" id="targetCGPA" step="0.01" min="0" max="4" 
                               class="block w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white/70 backdrop-blur-sm"
                               placeholder="3.50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-800 mb-2">Current CGPA</label>
                        <input type="number" id="currentCGPA" step="0.01" min="0" max="4" 
                               value="{{ number_format($cgpa ?? 0, 2) }}" readonly
                               class="block w-full rounded-lg border-blue-300 bg-blue-50/70 shadow-sm backdrop-blur-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-800 mb-2">Completed Credits</label>
                        <input type="number" id="completedCredits" 
                               value="{{ $totalCredits ?? 0 }}" readonly
                               class="block w-full rounded-lg border-blue-300 bg-blue-50/70 shadow-sm backdrop-blur-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-800 mb-2">Remaining Credits</label>
                        <input type="number" id="remainingCredits" 
                               value="{{ $remainingCredits ?? 0 }}" readonly
                               class="block w-full rounded-lg border-blue-300 bg-blue-50/70 shadow-sm backdrop-blur-sm">
                    </div>
                </div>
                
                <div class="flex justify-center mb-4">
                    <button id="calculateTargetBtn" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-calculator mr-2"></i>
                        Calculate Required GPA
                    </button>
                </div>
                
                <div id="targetResult" class="hidden p-4 rounded-lg border border-blue-300 bg-white/50 backdrop-blur-sm">
                    <!-- Result will be displayed here -->
                </div>
            </div>
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
                    <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-blue-400 transition-colors">Home</a></li>
                        <li><a href="/dashboard" class="text-gray-300 hover:text-blue-400 transition-colors">Dashboard</a></li>
                        <li><a href="/cgpa-tracker" class="text-gray-300 hover:text-blue-400 transition-colors">CGPA Tracker</a></li>
                        <li><a href="/my-courses" class="text-gray-300 hover:text-blue-400 transition-colors">My Courses</a></li>
                        <li><a href="/faculty-reviews" class="text-gray-300 hover:text-blue-400 transition-colors">Faculty Reviews</a></li>
                        <li><a href="/resource-hub" class="text-gray-300 hover:text-blue-400 transition-colors">Resources</a></li>
                    </ul>
                </div>

                <!-- Features -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Features</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-chart-line text-blue-400 mr-2"></i>
                            Course Management
                        </li>
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-calculator text-blue-400 mr-2"></i>
                            CGPA Tracking & Analytics
                        </li>
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-star text-blue-400 mr-2"></i>
                            Grade Recording
                        </li>
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-users text-blue-400 mr-2"></i>
                            Academic Progress Monitoring
                        </li>
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-tachometer-alt text-blue-400 mr-2"></i>
                            Student Dashboard
                        </li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Contact Us</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-university text-blue-400 mr-3"></i>
                            <span>Daffodil International University</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-envelope text-blue-400 mr-3"></i>
                            <span>support@diu.edu.bd</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-phone text-blue-400 mr-3"></i>
                            <span>+880-1234-567890</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Academic Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        let isMinimized = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const footer = document.getElementById('footer');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Update footer margins based on sidebar state
            if (sidebar.classList.contains('active')) {
                footer.classList.remove('sidebar-minimized');
                footer.classList.add('sidebar-expanded');
            } else {
                footer.classList.remove('sidebar-expanded');
                footer.classList.add('sidebar-minimized');
            }
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
            
            // Initialize CGPA Tracker functionality
            initializeCGPATracker();
        });

        // CGPA Tracker Functionality
        function initializeCGPATracker() {
            const levelSelect = document.getElementById('levelSelect');
            const termSelect = document.getElementById('termSelect');
            const loadCoursesBtn = document.getElementById('loadCoursesBtn');
            const coursesContainer = document.getElementById('coursesContainer');
            const coursesTableBody = document.getElementById('coursesTableBody');
            const saveGradesBtn = document.getElementById('saveGradesBtn');
            const calculateTargetBtn = document.getElementById('calculateTargetBtn');
            
            let currentCourses = [];
            
            // Grade point mapping
            const gradePoints = {
                'A+': 4.00, 'A': 3.75, 'A-': 3.50,
                'B+': 3.25, 'B': 3.00, 'B-': 2.75,
                'C+': 2.50, 'C': 2.25, 'C-': 2.00,
                'D+': 1.75, 'D': 1.50, 'F': 0.00
            };
            
            // Enable term select when level is selected
            levelSelect.addEventListener('change', function() {
                const selectedLevel = parseInt(this.value);
                termSelect.innerHTML = '<option value="">Select Term</option>';
                
                if (selectedLevel) {
                    // Find available terms for this level
                    const availableTerms = [];
                    @foreach($allSemesters as $semesterName => $semesterData)
                        @if($semesterData['is_available_for_input'] || !$semesterData['has_grades'])
                            if ({{ $semesterData['level'] }} === selectedLevel) {
                                availableTerms.push({
                                    value: {{ $semesterData['term'] }},
                                    text: 'Term {{ $semesterData['term'] }}',
                                    available: {{ $semesterData['is_available_for_input'] ? 'true' : 'false' }}
                                });
                            }
                        @endif
                    @endforeach
                    
                    // Populate term options
                    availableTerms.forEach(term => {
                        const option = document.createElement('option');
                        option.value = term.value;
                        option.textContent = term.text;
                        if (!term.available) {
                            option.disabled = true;
                            option.textContent += ' (Already completed)';
                        }
                        termSelect.appendChild(option);
                    });
                    
                    termSelect.disabled = false;
                    loadCoursesBtn.disabled = true;
                    coursesContainer.classList.add('hidden');
                } else {
                    termSelect.disabled = true;
                    termSelect.value = '';
                    loadCoursesBtn.disabled = true;
                    coursesContainer.classList.add('hidden');
                }
            });
            
            // Enable load button when both level and term are selected
            termSelect.addEventListener('change', function() {
                if (this.value && levelSelect.value) {
                    loadCoursesBtn.disabled = false;
                } else {
                    loadCoursesBtn.disabled = true;
                    coursesContainer.classList.add('hidden');
                }
            });
            
            // Load courses for selected level and term
            loadCoursesBtn.addEventListener('click', function() {
                const level = levelSelect.value;
                const term = termSelect.value;
                
                if (!level || !term) return;
                
                this.disabled = true;
                this.textContent = 'Loading...';
                
                fetch(`/grades/courses?level=${level}&term=${term}`)
                    .then(response => response.json())
                    .then(courses => {
                        currentCourses = courses;
                        displayCourses(courses);
                        coursesContainer.classList.remove('hidden');
                        this.disabled = false;
                        this.textContent = 'Load Courses';
                    })
                    .catch(error => {
                        console.error('Error loading courses:', error);
                        alert('Error loading courses. Please try again.');
                        this.disabled = false;
                        this.textContent = 'Load Courses';
                    });
            });
            
            // Display courses in table
            function displayCourses(courses) {
                coursesTableBody.innerHTML = '';
                
                courses.forEach(course => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-3">${course.code}</td>
                        <td class="px-4 py-3">${course.title}</td>
                        <td class="px-4 py-3">${course.credits}</td>
                        <td class="px-4 py-3">
                            <select class="grade-select w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" data-course-code="${course.code}" data-credits="${course.credits}">
                                <option value="">Select Grade</option>
                                <option value="A+">A+ (4.00)</option>
                                <option value="A">A (3.75)</option>
                                <option value="A-">A- (3.50)</option>
                                <option value="B+">B+ (3.25)</option>
                                <option value="B">B (3.00)</option>
                                <option value="B-">B- (2.75)</option>
                                <option value="C+">C+ (2.50)</option>
                                <option value="C">C (2.25)</option>
                                <option value="C-">C- (2.00)</option>
                                <option value="D+">D+ (1.75)</option>
                                <option value="D">D (1.50)</option>
                                <option value="F">F (0.00)</option>
                            </select>
                        </td>
                        <td class="px-4 py-3 grade-points">0.00</td>
                    `;
                    coursesTableBody.appendChild(row);
                });
                
                // Add event listeners to grade selects
                document.querySelectorAll('.grade-select').forEach(select => {
                    select.addEventListener('change', updateSemesterCalculations);
                });
            }
            
            // Update semester calculations
            function updateSemesterCalculations() {
                let totalCredits = 0;
                let totalGradePoints = 0;
                
                document.querySelectorAll('.grade-select').forEach(select => {
                    const grade = select.value;
                    const credits = parseFloat(select.dataset.credits);
                    const row = select.closest('tr');
                    const gradePointsCell = row.querySelector('.grade-points');
                    
                    if (grade && credits) {
                        const points = gradePoints[grade] * credits;
                        gradePointsCell.textContent = points.toFixed(2);
                        totalCredits += credits;
                        totalGradePoints += points;
                    } else {
                        gradePointsCell.textContent = '0.00';
                    }
                });
                
                const semesterGPA = totalCredits > 0 ? totalGradePoints / totalCredits : 0;
                document.getElementById('semesterCredits').textContent = `Total Credits: ${totalCredits}`;
                document.getElementById('semesterGPA').textContent = `Semester GPA: ${semesterGPA.toFixed(2)}`;
            }
            
            // Save grades
            saveGradesBtn.addEventListener('click', function() {
                const level = levelSelect.value;
                const term = termSelect.value;
                const grades = [];
                
                document.querySelectorAll('.grade-select').forEach(select => {
                    const grade = select.value;
                    if (grade) {
                        const course = currentCourses.find(c => c.code === select.dataset.courseCode);
                        grades.push({
                            course_code: select.dataset.courseCode,
                            course_name: course.title,
                            grade: grade,
                            credits: parseFloat(select.dataset.credits)
                        });
                    }
                });
                
                if (grades.length === 0) {
                    alert('Please select grades for at least one course.');
                    return;
                }
                
                this.disabled = true;
                this.textContent = 'Saving...';
                
                fetch('/grades/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        level: level,
                        term: term,
                        grades: grades
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message with more details
                        const successMsg = `✅ ${data.message}\n📚 ${data.saved_count} grades saved successfully!`;
                        alert(successMsg);
                        
                        // Redirect or reload to show updated results
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            location.reload(); // Refresh to show updated CGPA
                        }
                    } else {
                        alert('Error: ' + (data.message || 'Failed to save grades'));
                    }
                })
                .catch(error => {
                    console.error('Error saving grades:', error);
                    alert('Error saving grades. Please check your internet connection and try again.');
                })
                .finally(() => {
                    this.disabled = false;
                    this.textContent = 'Save Grades';
                });
            });
            
            // Calculate target CGPA
            calculateTargetBtn.addEventListener('click', function() {
                const targetCGPA = parseFloat(document.getElementById('targetCGPA').value);
                const currentCGPA = parseFloat(document.getElementById('currentCGPA').value);
                const completedCredits = parseFloat(document.getElementById('completedCredits').value);
                const remainingCredits = parseFloat(document.getElementById('remainingCredits').value);
                
                if (!targetCGPA || targetCGPA < 0 || targetCGPA > 4) {
                    alert('Please enter a valid target CGPA (0.00 - 4.00)');
                    return;
                }
                
                fetch('/grades/calculate-target', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        target_cgpa: targetCGPA,
                        current_cgpa: currentCGPA,
                        completed_credits: completedCredits,
                        remaining_credits: remainingCredits
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('targetResult');
                    resultDiv.classList.remove('hidden');
                    
                    if (data.achievable) {
                        resultDiv.className = 'p-4 rounded-lg border border-green-200 bg-green-50';
                        resultDiv.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                <div>
                                    <h4 class="font-medium text-green-800">Target Achievable!</h4>
                                    <p class="text-green-700">${data.message}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        resultDiv.className = 'p-4 rounded-lg border border-red-200 bg-red-50';
                        resultDiv.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                <div>
                                    <h4 class="font-medium text-red-800">Target Not Achievable</h4>
                                    <p class="text-red-700">${data.message}</p>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error calculating target CGPA:', error);
                    alert('Error calculating target CGPA. Please try again.');
                });
            });
        }
        
        // Function to select semester for input (called from semester display)
        function selectSemesterForInput(level, term) {
            const levelSelect = document.getElementById('levelSelect');
            const termSelect = document.getElementById('termSelect');
            const loadCoursesBtn = document.getElementById('loadCoursesBtn');
            
            // Set the values
            levelSelect.value = level;
            termSelect.disabled = false;
            termSelect.value = term;
            loadCoursesBtn.disabled = false;
            
            // Scroll to the input section
            document.querySelector('#coursesContainer').parentElement.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
            
            // Automatically load courses
            loadCoursesBtn.click();
        }

        // Mobile Menu Functions
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('mobile-menu-icon');
            
            mobileMenu.classList.toggle('hidden');
            
            // Animate hamburger icon
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            } else {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            }
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = event.target.closest('button[onclick="toggleMobileMenu()"]');
            
            if (!mobileMenu.contains(event.target) && !mobileMenuButton && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                const menuIcon = document.getElementById('mobile-menu-icon');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        });
    </script>

</body>
</html>
