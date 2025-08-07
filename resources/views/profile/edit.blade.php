<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Academic Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                    <a href="{{ route('profile') }}" class="flex items-center text-white/90 hover:text-white transition-colors group">
                        @if($user->profile_picture)
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
                        <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                        <p class="text-xs text-gray-600">{{ ucfirst($user->role) }}</p>
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
                
                @if($user->role === 'student')
                    <a href="{{ route('courses.my-courses') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-book text-lg"></i>
                        <span class="sidebar-text">My Courses</span>
                    </a>
                    <a href="{{ route('grades.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
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
                @elseif($user->role === 'faculty')
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
                @elseif($user->role === 'admin')
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
                    <a href="{{ route('profile') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3">
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
            <!-- Display success messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display error messages -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Edit Profile</h1>
                <p class="text-gray-600">Update your personal information and profile settings</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Picture Upload -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Profile Picture</h3>
                        <div class="text-center">
                            <div class="mb-4">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=fff&size=150' }}" 
                                     alt="Current Profile Picture" 
                                     class="w-32 h-32 rounded-full mx-auto border-4 border-gray-200 object-cover"
                                     id="preview-image">
                            </div>
                            <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <input type="file" 
                                           name="profile_picture" 
                                           id="profile_picture" 
                                           accept="image/*"
                                           onchange="previewImage(event)"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300">
                                    <i class="fas fa-upload mr-2"></i>Upload Picture
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Information Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Personal Information</h3>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <!-- Department -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                    <select id="department_id" name="department_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }} ({{ $department->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Student ID -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
                                    <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $user->student_id) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <!-- Admission Semester (if student) -->
                                @if($user->role === 'student')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Admission Semester</label>
                                    <select id="admission_semester" name="admission_semester" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Semester</option>
                                        <option value="Spring" {{ old('admission_semester', $user->admission_semester) === 'Spring' ? 'selected' : '' }}>Spring</option>
                                        <option value="Summer" {{ old('admission_semester', $user->admission_semester) === 'Summer' ? 'selected' : '' }}>Summer</option>
                                        <option value="Fall" {{ old('admission_semester', $user->admission_semester) === 'Fall' ? 'selected' : '' }}>Fall</option>
                                    </select>
                                </div>
                                <!-- Admission Year -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Admission Year</label>
                                    <input type="number" id="admission_year" name="admission_year" value="{{ old('admission_year', $user->admission_year) }}" min="2000" max="{{ date('Y') + 1 }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                @endif
                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <textarea id="address" name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end space-x-4">
                                <a href="{{ route('profile') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-300">Cancel</a>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-300">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
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
                sidebar.classList.toggle('active');
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
                
                // Save preference
                localStorage.setItem('sidebarMinimized', isMinimized);
            }
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('mobile-menu-icon');
            
            mobileMenu.classList.toggle('hidden');
            
            // Toggle icon between bars and X
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            } else {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            }
        }

        function toggleNightMode() {
            document.body.classList.toggle('dark');
            const desktopToggle = document.getElementById('nightModeToggle');
            const mobileToggle = document.getElementById('mobile-night-mode-toggle');
            
            const isDark = document.body.classList.contains('dark');
            
            // Sync both toggles
            if (desktopToggle) {
                if (isDark) {
                    desktopToggle.classList.add('active');
                } else {
                    desktopToggle.classList.remove('active');
                }
            }
            
            if (mobileToggle) {
                if (isDark) {
                    mobileToggle.classList.add('active');
                } else {
                    mobileToggle.classList.remove('active');
                }
            }
            
            // Save preference
            localStorage.setItem('darkMode', isDark);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check for saved sidebar preference
            const savedMinimized = localStorage.getItem('sidebarMinimized') === 'true';
            if (savedMinimized && window.innerWidth >= 1024) {
                isMinimized = true;
                toggleSidebarSize();
            } else if (window.innerWidth >= 1024) {
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                mainContent.classList.add('sidebar-expanded');
                footer.classList.add('sidebar-expanded');
            }

            // Check for saved dark mode preference
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.body.classList.add('dark');
                const desktopToggle = document.getElementById('nightModeToggle');
                const mobileToggle = document.getElementById('mobile-night-mode-toggle');
                if (desktopToggle) desktopToggle.classList.add('active');
                if (mobileToggle) mobileToggle.classList.add('active');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = event.target.closest('button[onclick="toggleMobileMenu()"]');
            
            if (mobileMenu && !mobileMenu.contains(event.target) && !mobileMenuButton) {
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    document.getElementById('mobile-menu-icon').classList.remove('fa-times');
                    document.getElementById('mobile-menu-icon').classList.add('fa-bars');
                }
            }
            
            // Existing sidebar close logic
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

        // Profile picture preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

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
    </script>
</body>
</html>
