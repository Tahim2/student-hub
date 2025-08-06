<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Academic Hub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        /* Dark mode styles */
        .dark {
            background-color: #1a202c;
            color: #e2e8f0;
        }
        .dark .sidebar-bg {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        }
        .dark .sidebar-item {
            color: #e2e8f0;
        }
        .dark .sidebar-item:hover {
            background: rgba(59, 130, 246, 0.2);
            color: #90cdf4;
        }
        .dark .sidebar-item.active {
            background: rgba(59, 130, 246, 0.3);
            color: #90cdf4;
        }
        .dark .main-content {
            background: #1a202c;
        }
        .dark .bg-white {
            background-color: #2d3748 !important;
        }
        .dark .text-gray-800 {
            color: #e2e8f0 !important;
        }
        .dark .text-gray-600 {
            color: #a0aec0 !important;
        }
        .dark .text-gray-900 {
            color: #f7fafc !important;
        }
        .dark .border-gray-200 {
            border-color: #4a5568 !important;
        }
        .dark .stats-card {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        }
        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            height: calc(100vh - 80px);
            width: 280px;
            transform: translateX(0); /* Always visible on desktop */
            transition: transform 0.3s ease;
            z-index: 30;
            overflow-y: auto;
        }
        .sidebar.minimized {
            width: 70px;
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
            margin-left: 280px; /* Always account for sidebar on desktop */
            padding-top: 80px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: #f8fafc;
        }
        .main-content.sidebar-minimized {
            margin-left: 70px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 4px 12px;
        }
        .sidebar-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            transform: translateX(4px);
        }
        .sidebar-item.active {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            font-weight: 600;
        }
        .sidebar-item i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }
        .sidebar.minimized .sidebar-text {
            display: none;
        }
        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Footer styles to account for sidebar */
        .footer {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }
        .footer.sidebar-minimized {
            margin-left: 70px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .main-content.sidebar-minimized {
                margin-left: 0;
            }
            .footer {
                margin-left: 0;
            }
            .footer.sidebar-minimized {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Main Navigation (consistent with layouts.app) -->
    <nav class="gradient-bg text-white shadow-lg fixed w-full top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-graduation-cap text-2xl mr-2"></i>
                        <span class="font-bold text-xl">Academic Hub</span>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Profile Icon -->
                    <a href="#profile" class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition-colors">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                    </a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-2">
                    <!-- Mobile sidebar toggle -->
                    <button id="mobile-sidebar-toggle" class="text-white hover:text-gray-200 focus:outline-none focus:text-gray-200 p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="md:hidden absolute top-full right-4 w-64 bg-white dark:bg-gray-800 backdrop-blur-sm shadow-lg rounded-lg border border-gray-200 dark:border-gray-600 hidden z-50">
            <div class="px-2 py-3 space-y-1 max-h-96 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>Dashboard
                </a>
                
                <!-- Course Assignments -->
                <a href="{{ route('admin.course-assignments.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-chalkboard-teacher w-5 mr-3"></i>Course Assignments
                </a>
                
                <!-- Users -->
                <a href="#users" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-users w-5 mr-3"></i>Users
                </a>
                
                <!-- Courses -->
                <a href="#courses" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-book w-5 mr-3"></i>Courses
                </a>
                
                <!-- Departments -->
                <a href="#departments" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-building w-5 mr-3"></i>Departments
                </a>
                
                <!-- Reviews -->
                <a href="#reviews" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-star w-5 mr-3"></i>Reviews
                </a>
                
                <!-- Analytics -->
                <a href="#analytics" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>Analytics
                </a>
                
                <hr class="my-2 border-gray-200 dark:border-gray-600">
                
                <!-- Profile -->
                <a href="#profile" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-user w-5 mr-3"></i>Profile
                </a>
                
                <!-- Settings -->
                <a href="#settings" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-cog w-5 mr-3"></i>Settings
                </a>
                
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggleMobile" class="w-full flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-moon w-5 mr-3"></i>Dark Mode
                </button>
                
                <!-- Logout -->
                <a href="{{ route('logout') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt w-5 mr-3"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Admin Sidebar -->
    <aside id="adminSidebar" class="sidebar sidebar-bg border-r border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-shield text-white text-lg"></i>
                </div>
                <div class="sidebar-text">
                    <h2 class="text-gray-800 font-bold text-lg">Admin Panel</h2>
                    <p class="text-gray-500 text-sm">Administration</p>
                </div>
            </div>
        </div>
        
        <nav class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.course-assignments.index') }}" class="sidebar-item {{ request()->routeIs('admin.course-assignments.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span class="sidebar-text">Assign Teachers</span>
            </a>
            
            <a href="#users" class="sidebar-item">
                <i class="fas fa-users"></i>
                <span class="sidebar-text">Manage Users</span>
            </a>
            
            <a href="#courses" class="sidebar-item">
                <i class="fas fa-book"></i>
                <span class="sidebar-text">Manage Courses</span>
            </a>
            
            <a href="#departments" class="sidebar-item">
                <i class="fas fa-building"></i>
                <span class="sidebar-text">Departments</span>
            </a>
            
            <a href="#reviews" class="sidebar-item">
                <i class="fas fa-star"></i>
                <span class="sidebar-text">Faculty Reviews</span>
            </a>
            
            <a href="#resources" class="sidebar-item">
                <i class="fas fa-folder"></i>
                <span class="sidebar-text">Resources</span>
            </a>
            
            <a href="#reports" class="sidebar-item">
                <i class="fas fa-chart-line"></i>
                <span class="sidebar-text">Reports</span>
            </a>
            
            <div class="mt-8 border-t border-gray-200 pt-4">
                <a href="#profile" class="sidebar-item">
                    <i class="fas fa-user"></i>
                    <span class="sidebar-text">Profile</span>
                </a>
                
                <a href="#settings" class="sidebar-item">
                    <i class="fas fa-cog"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
                
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggle" class="sidebar-item w-full text-left" title="Toggle Dark Mode">
                    <i class="fas fa-moon"></i>
                    <span class="sidebar-text">Dark Mode</span>
                </button>
                
                <a href="{{ route('logout') }}" class="sidebar-item text-red-600 hover:text-red-700 hover:bg-red-50"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="sidebar-text">Logout</span>
                </a>
            </div>
        </nav>
        
        <!-- Sidebar Toggle Button -->
        <div class="absolute top-4 right-4">
            <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 transition-colors p-1 rounded">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
        </div>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <!-- Main Content -->
    <main id="mainContent" class="main-content">
        <div class="container mx-auto px-6 py-8">
            @yield('admin-content')
        </div>
    </main>

    <!-- Footer (consistent with main app) -->
    <footer id="footer" class="footer bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl mr-2"></i>
                        <span class="font-bold text-xl">Academic Hub</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Empowering education through innovative technology. Your gateway to academic excellence and seamless learning experiences.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Academic Programs</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Faculty</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Research</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Campus Life</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>123 University Ave, Academic City</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>info@academichub.edu</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Mon-Fri: 8:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">
                    &copy; 2025 Academic Hub. All rights reserved. | 
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a> | 
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const footer = document.getElementById('footer');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
        
        let isMinimized = false;
        
        // Dark Mode functionality
        function toggleDarkMode() {
            document.body.classList.toggle('dark');
            const isDark = document.body.classList.contains('dark');
            
            // Update icons
            const sidebarIcon = darkModeToggle ? darkModeToggle.querySelector('i') : null;
            const mobileIcon = darkModeToggleMobile ? darkModeToggleMobile.querySelector('i') : null;
            
            if (isDark) {
                if (sidebarIcon) {
                    sidebarIcon.classList.remove('fa-moon');
                    sidebarIcon.classList.add('fa-sun');
                }
                if (mobileIcon) {
                    mobileIcon.classList.remove('fa-moon');
                    mobileIcon.classList.add('fa-sun');
                }
                localStorage.setItem('darkMode', 'enabled');
            } else {
                if (sidebarIcon) {
                    sidebarIcon.classList.remove('fa-sun');
                    sidebarIcon.classList.add('fa-moon');
                }
                if (mobileIcon) {
                    mobileIcon.classList.remove('fa-sun');
                    mobileIcon.classList.add('fa-moon');
                }
                localStorage.setItem('darkMode', 'disabled');
            }
        }
        
        // Dark mode toggle event listeners
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', toggleDarkMode);
        }
        if (darkModeToggleMobile) {
            darkModeToggleMobile.addEventListener('click', toggleDarkMode);
        }
        
        // Load saved dark mode preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark');
            if (darkModeToggle) {
                darkModeToggle.querySelector('i').classList.remove('fa-moon');
                darkModeToggle.querySelector('i').classList.add('fa-sun');
            }
            if (darkModeToggleMobile) {
                darkModeToggleMobile.querySelector('i').classList.remove('fa-moon');
                darkModeToggleMobile.querySelector('i').classList.add('fa-sun');
            }
        }
        
        // Toggle sidebar minimize/maximize
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth > 768) {
                    isMinimized = !isMinimized;
                    sidebar.classList.toggle('minimized');
                    
                    if (isMinimized) {
                        mainContent.classList.add('sidebar-minimized');
                        footer.classList.add('sidebar-minimized');
                        sidebarToggle.querySelector('i').classList.remove('fa-chevron-left');
                        sidebarToggle.querySelector('i').classList.add('fa-chevron-right');
                    } else {
                        mainContent.classList.remove('sidebar-minimized');
                        footer.classList.remove('sidebar-minimized');
                        sidebarToggle.querySelector('i').classList.remove('fa-chevron-right');
                        sidebarToggle.querySelector('i').classList.add('fa-chevron-left');
                    }
                }
            });
        }
        
        // Mobile sidebar toggle
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', function() {
                // On mobile, toggle the navbar dropdown menu instead of sidebar
                mobileMenu.classList.toggle('hidden');
            });
        }
        
        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                mobileMenu.classList.add('hidden');
            }
        });
        
        // Sidebar item active state
        const sidebarItems = document.querySelectorAll('.sidebar-item');
        sidebarItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (!this.href || !this.href.includes('logout')) {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    });
    </script>
</body>
</html>
