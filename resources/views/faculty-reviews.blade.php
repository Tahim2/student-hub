<!DOCTYPE html>
<html lang="en">
<!-- Rate Faculty FINAL - Consistent Design: 2025-08-04 -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rate Faculty - Academic Hub</title>
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
            color: #a0aec0 !important;
        }
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        .dark .hover\\:bg-gray-50:hover {
            background-color: #374151 !important;
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
        @media (max-width: 1024px) {
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
            }
            
            .main-content {
                margin-left: 280px;
                padding-top: 80px;
            }
            
            .footer-margin {
                margin-left: 280px;
            }
        }
        
        /* Mobile Styles */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding-top: 80px;
            }
            
            .footer-margin {
                margin-left: 0;
            }
            
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Course card styles */
        .course-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
        }
        
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }
        
        .course-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        
        .course-info {
            flex: 1;
            margin-right: 16px;
        }
        
        .course-code {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .course-name {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .faculty-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: #4b5563;
        }
        
        .course-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.125rem;
            flex-shrink: 0;
        }
        
        .rate-button {
            width: 100%;
            background: #3b82f6;
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .rate-button:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .course-footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 16px;
            margin-top: 16px;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 640px) {
            .course-card {
                padding: 16px;
                margin-bottom: 12px;
            }
            
            .course-header {
                margin-bottom: 12px;
            }
            
            .course-info {
                margin-right: 12px;
            }
            
            .course-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .course-code {
                font-size: 1rem;
                margin-bottom: 6px;
            }
            
            .course-name {
                font-size: 0.8rem;
                margin-bottom: 6px;
            }
            
            .faculty-info {
                font-size: 0.8rem;
            }
            
            .rate-button {
                padding: 10px 12px;
                font-size: 0.875rem;
            }
            
            .course-footer {
                padding-top: 12px;
                margin-top: 12px;
            }
            
            /* Compact rating sections on mobile */
            .rating-section {
                margin-bottom: 12px;
            }
            
            .rating-section label {
                font-size: 0.8rem;
                margin-bottom: 4px;
            }
            
            .rating-section .star-rating {
                font-size: 1.25rem;
            }
        }
        
        /* Success message styles */
        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .success-message.show {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg fixed w-full top-0 z-40">
        <div class="container mx-auto px-6 py-4 relative">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Desktop Sidebar Toggle - ONLY shows on large screens -->
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
                        <a href="{{ route('faculty-reviews.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors bg-blue-50 dark:bg-gray-700">
                            <i class="fas fa-star w-5 text-center mr-3 text-orange-600 dark:text-orange-400"></i>
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
    
    <!-- Navigation and sidebar are already present. All duplicate nav/dark mode and unnecessary sections above the welcome user section have been removed for a clean, professional look. -->

    <!-- Sidebar (single, consistent) -->
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
                    <a href="{{ route('grades.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-chart-line text-lg"></i>
                        <span class="sidebar-text">CGPA Tracker</span>
                    </a>
                    <a href="{{ route('faculty-reviews.index') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3">
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
                <h1 class="text-3xl font-bold text-gray-900">Rate Faculty</h1>
                <p class="text-gray-600 mt-2">Review and rate faculty members for your current semester courses</p>
            </div>

            <!-- Current Semester Info -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Your Current Semester
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>{{ $currentSemesterDetails['display'] ?? 'Semester information not available' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faculty and Courses Grid -->
            @if($facultyAssignments && $facultyAssignments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($facultyAssignments as $assignment)
                        <div class="course-card">
                            <div class="course-header">
                                <div class="course-info">
                                    <h3 class="course-code">
                                        {{ $assignment->course->course_code }}
                                    </h3>
                                    <p class="course-name">{{ $assignment->course->course_name }}</p>
                                    <div class="faculty-info">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $assignment->faculty->name }}</span>
                                    </div>
                                    <div class="faculty-info mt-1">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>{{ $assignment->course->credits }} Credits</span>
                                    </div>
                                </div>
                                <div class="course-icon">
                                    {{ substr($assignment->course->course_code, 0, 1) }}
                                </div>
                            </div>
                            
                            <div class="course-footer">
                                <button onclick="openReviewModal({{ json_encode($assignment) }})" 
                                        class="rate-button">
                                    <i class="fas fa-star"></i>
                                    <span>Rate Faculty</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Faculty Assignments</h3>
                    <p class="text-gray-500 mb-4">There are no faculty assignments available for your current semester.</p>
                    <div class="text-sm text-gray-400">
                        <p>Current semester: {{ $currentSemesterDetails['display'] ?? 'Not available' }}</p>
                        <p class="mt-1">Please check with your academic advisor if this seems incorrect.</p>
                    </div>
                </div>
            @endif
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

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 sticky top-0 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Rate Faculty</h3>
                    <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <form id="reviewForm" method="POST" action="{{ route('faculty-reviews.store') }}">
                @csrf
                <div class="px-6 py-4">
                    <div id="modalContent">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                    
                    <!-- Rating Section -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Rate this Faculty</h4>
                        
                        <!-- Overall Rating -->
                        <div class="mb-4 rating-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Overall Rating</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('overall_rating', {{ $i }})" 
                                            class="star-rating overall_rating text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors"
                                            data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="overall_rating" id="overall_rating" required>
                        </div>

                        <!-- Teaching Quality -->
                        <div class="mb-4 rating-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teaching Quality</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('teaching_quality', {{ $i }})" 
                                            class="star-rating teaching_quality text-xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors"
                                            data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="teaching_quality" id="teaching_quality" required>
                        </div>

                        <!-- Communication -->
                        <div class="mb-4 rating-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Communication</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('communication', {{ $i }})" 
                                            class="star-rating communication text-xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors"
                                            data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="communication" id="communication" required>
                        </div>

                        <!-- Course Organization -->
                        <div class="mb-4 rating-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course Organization</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('course_organization', {{ $i }})" 
                                            class="star-rating course_organization text-xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors"
                                            data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="course_organization" id="course_organization" required>
                        </div>

                        <!-- Helpfulness -->
                        <div class="mb-4 rating-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Helpfulness</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('helpfulness', {{ $i }})" 
                                            class="star-rating helpfulness text-xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors"
                                            data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="helpfulness" id="helpfulness" required>
                        </div>

                        <!-- Fairness -->
                        <div class="mb-4 rating-section">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fairness</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('fairness', {{ $i }})" 
                                            class="star-rating fairness text-xl text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors"
                                            data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="fairness" id="fairness" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="review_text" class="block text-sm font-medium text-gray-700 mb-2">Review (Optional)</label>
                        <textarea name="review_text" id="review_text" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                  placeholder="Share your experience with this faculty member..."
                                  style="min-height: 100px;"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="anonymous" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Submit anonymously</span>
                        </label>
                    </div>
                    
                    <input type="hidden" name="faculty_id" id="facultyIdInput">
                    <input type="hidden" name="course_id" id="courseIdInput">
                </div>
                
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="closeReviewModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let sidebarMinimized = false;

        // Check initial state from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize sidebar state on desktop
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                const sidebarMinimizedStorage = localStorage.getItem('sidebarMinimized');
                
                if (sidebarMinimizedStorage === 'true') {
                    sidebarMinimized = true;
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
            
            // Initialize dark mode
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'true') {
                document.body.classList.add('dark');
                const nightModeToggle = document.getElementById('nightModeToggle');
                const mobileNightModeToggle = document.getElementById('mobileNightModeToggle');
                if (nightModeToggle) nightModeToggle.classList.add('active');
                if (mobileNightModeToggle) mobileNightModeToggle.classList.add('active');
            }
        });

        // Sidebar toggle for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Sidebar size toggle for desktop
        function toggleSidebarSize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const footer = document.getElementById('footer');
            const toggleIcon = document.getElementById('toggleIcon');
            
            sidebarMinimized = !sidebarMinimized;
            
            if (sidebarMinimized) {
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
            
            localStorage.setItem('sidebarMinimized', sidebarMinimized);
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuIcon = document.getElementById('mobile-menu-icon');
            
            mobileMenu.classList.toggle('hidden');
            
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenuIcon.classList.remove('fa-times');
                mobileMenuIcon.classList.add('fa-bars');
            } else {
                mobileMenuIcon.classList.remove('fa-bars');
                mobileMenuIcon.classList.add('fa-times');
            }
        }

        // Dark mode toggle
        function toggleNightMode() {
            document.body.classList.toggle('dark');
            const isDark = document.body.classList.contains('dark');
            
            const nightModeToggle = document.getElementById('nightModeToggle');
            const mobileNightModeToggle = document.getElementById('mobileNightModeToggle');
            
            if (isDark) {
                if (nightModeToggle) nightModeToggle.classList.add('active');
                if (mobileNightModeToggle) mobileNightModeToggle.classList.add('active');
            } else {
                if (nightModeToggle) nightModeToggle.classList.remove('active');
                if (mobileNightModeToggle) mobileNightModeToggle.classList.remove('active');
            }
            
            localStorage.setItem('darkMode', isDark);
        }

        // Faculty rating functionality
        let ratings = {
            overall_rating: 0,
            teaching_quality: 0,
            communication: 0,
            course_organization: 0,
            helpfulness: 0,
            fairness: 0
        };

        function openReviewModal(assignment) {
            const modal = document.getElementById('reviewModal');
            const modalContent = document.getElementById('modalContent');
            const facultyIdInput = document.getElementById('facultyIdInput');
            const courseIdInput = document.getElementById('courseIdInput');
            
            // Reset ratings
            ratings = {
                overall_rating: 0,
                teaching_quality: 0,
                communication: 0,
                course_organization: 0,
                helpfulness: 0,
                fairness: 0
            };
            resetAllStars();
            
            // Clear form
            document.getElementById('review_text').value = '';
            document.querySelector('input[name="anonymous"]').checked = false;
            
            // Set hidden inputs
            facultyIdInput.value = assignment.faculty_id;
            courseIdInput.value = assignment.course_id;
            
            // Set modal content
            modalContent.innerHTML = `
                <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-medium text-blue-900">${assignment.course.course_code}</h4>
                    <p class="text-sm text-blue-800">${assignment.course.course_name}</p>
                    <p class="text-sm text-blue-700 mt-1">Faculty: ${assignment.faculty.name}</p>
                </div>
            `;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function setRating(category, rating) {
            ratings[category] = rating;
            document.getElementById(category).value = rating;
            
            const stars = document.querySelectorAll(`.star-rating.${category}`);
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        function resetAllStars() {
            const allStars = document.querySelectorAll('.star-rating');
            allStars.forEach(star => {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            });
            
            // Clear hidden inputs
            Object.keys(ratings).forEach(category => {
                const input = document.getElementById(category);
                if (input) input.value = '';
            });
        }

        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Check if all required ratings are provided
            const requiredRatings = ['overall_rating', 'teaching_quality', 'communication', 'course_organization', 'helpfulness', 'fairness'];
            const missingRatings = requiredRatings.filter(category => ratings[category] === 0);
            
            if (missingRatings.length > 0) {
                alert('Please provide ratings for all categories before submitting.');
                return false;
            }
            
            // Submit form via AJAX
            const formData = new FormData(this);
            
            // Ensure all rating fields are included with proper values
            Object.keys(ratings).forEach(category => {
                if (ratings[category] > 0) {
                    formData.set(category, ratings[category]);
                }
            });
            
            // Handle anonymous checkbox properly
            const anonymousCheckbox = document.querySelector('input[name="anonymous"]');
            formData.set('anonymous', anonymousCheckbox.checked ? '1' : '0');
            
            // Debug: Log form data
            console.log('Form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        throw new Error(`HTTP error! status: ${response.status}, response: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showSuccessMessage(data.message);
                    closeReviewModal();
                    // Optionally reload the page to show updated state
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert(data.error || 'An error occurred while submitting your review.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting your review. Please check console for details.');
            });
        });

        // Success message function
        function showSuccessMessage(message) {
            // Remove any existing success message
            const existingMessage = document.querySelector('.success-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            // Create new success message
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message';
            successDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(successDiv);
            
            // Show the message
            setTimeout(() => {
                successDiv.classList.add('show');
            }, 100);
            
            // Hide the message after 3 seconds
            setTimeout(() => {
                successDiv.classList.remove('show');
                setTimeout(() => {
                    successDiv.remove();
                }, 300);
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = e.target.closest('button[onclick="toggleMobileMenu()"]');
            
            if (!mobileMenuButton && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                const mobileMenuIcon = document.getElementById('mobile-menu-icon');
                mobileMenuIcon.classList.remove('fa-times');
                mobileMenuIcon.classList.add('fa-bars');
            }
        });
    </script>
</body>
</html>
