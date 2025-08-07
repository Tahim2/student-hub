<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Academic Hub</title>
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
        .settings-card {
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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
        
        .dark .bg-gray-200 {
            background-color: #374151 !important;
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
            color: #6b7280 !important;
        }
        
        .dark .border-gray-200 {
            border-color: #374151 !important;
        }
        
        .dark .border-gray-300 {
            border-color: #4b5563 !important;
        }
        
        .dark .hover\:bg-gray-100:hover {
            background-color: #374151 !important;
        }
        
        .dark .hover\:bg-gray-200:hover {
            background-color: #4b5563 !important;
        }
        
        .dark .bg-blue-100 {
            background-color: #1e40af !important;
        }
        
        .dark .text-blue-600 {
            color: #60a5fa !important;
        }
        
        .dark .bg-purple-100 {
            background-color: #6d28d9 !important;
        }
        
        .dark .text-purple-600 {
            color: #c084fc !important;
        }
        
        .dark .bg-green-100 {
            background-color: #15803d !important;
        }
        
        .dark .text-green-600 {
            color: #4ade80 !important;
        }
        
        .dark .bg-red-100 {
            background-color: #dc2626 !important;
        }
        
        .dark .text-red-600 {
            color: #f87171 !important;
        }
        
        .dark .text-red-900 {
            color: #fca5a5 !important;
        }
        
        .dark .bg-red-50 {
            background-color: #7f1d1d !important;
        }
        
        .dark .hover\:bg-red-100:hover {
            background-color: #991b1b !important;
        }
        
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.3) !important;
        }
        
        .dark .sidebar-header {
            border-bottom-color: #374151 !important;
        }
        
        .dark input, .dark select, .dark textarea {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #f1f5f9 !important;
        }
        
        .dark input:focus, .dark select:focus, .dark textarea:focus {
            border-color: #60a5fa !important;
            background-color: #1f2937 !important;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1) !important;
        }
        
        .dark input:disabled {
            background-color: #111827 !important;
            color: #9ca3af !important;
        }
        
        .dark .settings-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
        }
        
        .dark .bg-gray-900 {
            background-color: #000000 !important;
        }
        
        .dark .border-gray-800 {
            border-color: #1f2937 !important;
        }
        
        .dark .text-gray-300 {
            color: #d1d5db !important;
        }
        
        .dark .text-gray-400 {
            color: #9ca3af !important;
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
                        <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
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
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3" onclick="toggleNightMode()">
                        <i class="fas fa-moon text-lg"></i>
                        <span class="sidebar-text">Dark Mode</span>
                        <div class="toggle-switch ml-auto" id="nightModeToggle">
                            <div class="toggle-slider"></div>
                        </div>
                    </a>
                    <a href="{{ route('settings') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-cog text-lg"></i>
                        <span class="sidebar-text">Settings</span>
                    </a>
                    <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3">
                        <i class="fas fa-question-circle text-lg"></i>
                        <span class="sidebar-text">Help & Support</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="sidebar-item">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-left hover:bg-red-50 hover:text-red-600 transition-colors">
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
            <!-- Settings Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Settings</h1>
                <p class="text-gray-600">Manage your account preferences and settings</p>
            </div>

            <!-- Settings Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <!-- Preferences Settings -->
                <div class="settings-card bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-palette text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Preferences</h2>
                            <p class="text-gray-600">Customize your experience</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Notifications -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-bell text-gray-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Notifications</p>
                                    <p class="text-sm text-gray-600">Receive email notifications</p>
                                </div>
                            </div>
                            <div class="toggle-switch active" id="notificationToggle">
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        
                        <!-- Language -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3 mb-3">
                                <i class="fas fa-language text-gray-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Language</p>
                                    <p class="text-sm text-gray-600">Choose your preferred language</p>
                                </div>
                            </div>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="en">English</option>
                                <option value="bn">বাংলা</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="settings-card bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Security</h2>
                            <p class="text-gray-600">Manage your account security</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <button class="w-full p-4 text-left bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-key text-gray-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Change Password</p>
                                    <p class="text-sm text-gray-600">Update your login password</p>
                                </div>
                            </div>
                        </button>
                        
                        <button class="w-full p-4 text-left bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-mobile-alt text-gray-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Two-Factor Authentication</p>
                                    <p class="text-sm text-gray-600">Add an extra layer of security</p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Account Actions -->
                <div class="settings-card bg-white rounded-2xl shadow-lg p-6 lg:p-8">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="bg-red-100 p-3 rounded-full">
                            <i class="fas fa-cog text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Account Actions</h2>
                            <p class="text-gray-600">Manage your account</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <button class="w-full p-4 text-left bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-download text-gray-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Export Data</p>
                                    <p class="text-sm text-gray-600">Download your account data</p>
                                </div>
                            </div>
                        </button>
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
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Faculty Reviews</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Resources</a></li>
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
            
            sidebar.classList.toggle('active');
            
            // Handle overlay for mobile
            if (window.innerWidth < 1024) {
                overlay.classList.toggle('active');
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

        // Profile form submission
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            button.textContent = 'Updated!';
            button.classList.add('bg-green-600');
            button.classList.remove('bg-blue-600');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-blue-600');
            }, 2000);
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
