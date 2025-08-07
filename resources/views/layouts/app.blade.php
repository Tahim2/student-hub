<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Academic Hub')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        /* Animation utilities */
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @yield('styles')
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Enhanced Top Navigation with Dropdown Menus -->
    <nav class="gradient-bg shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-white hover:text-white/90 transition-colors">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                        <span class="text-xl font-bold">Academic Hub</span>
                    </a>
                </div>

                <!-- Desktop Navigation Menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : '' }}">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>

                    <!-- Academic Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-colors flex items-center {{ request()->routeIs('courses.*', 'grades.*') ? 'bg-white/20 text-white' : '' }}">
                            <i class="fas fa-book mr-2"></i>Academic
                            <i class="fas fa-chevron-down ml-2 text-sm group-hover:rotate-180 transition-transform"></i>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2">
                            <div class="py-2">
                                <a href="{{ route('courses.my-courses') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('courses.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                    <i class="fas fa-book text-blue-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">My Courses</div>
                                        <div class="text-xs text-gray-500">View enrolled courses</div>
                                    </div>
                                </a>
                                <a href="{{ route('grades.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('grades.*') ? 'bg-green-50 text-green-600' : '' }}">
                                    <i class="fas fa-chart-line text-green-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">CGPA Tracker</div>
                                        <div class="text-xs text-gray-500">Track academic performance</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-colors flex items-center {{ request()->routeIs('faculty-reviews.*') ? 'bg-white/20 text-white' : '' }}">
                            <i class="fas fa-star mr-2"></i>Faculty
                            <i class="fas fa-chevron-down ml-2 text-sm group-hover:rotate-180 transition-transform"></i>
                        </button>
                        <div class="absolute top-full left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2">
                            <div class="py-2">
                                <a href="{{ route('faculty-reviews.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition-colors {{ request()->routeIs('faculty-reviews.*') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                                    <i class="fas fa-star text-yellow-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">Rate Faculty</div>
                                        <div class="text-xs text-gray-500">Review and rate professors</div>
                                    </div>
                                </a>
                                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors">
                                    <i class="fas fa-download text-purple-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">Resources</div>
                                        <div class="text-xs text-gray-500">Download study materials</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile & More Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg transition-colors flex items-center">
                            @auth
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="w-6 h-6 rounded-full border border-white/20 mr-2 object-cover">
                                @else
                                    <i class="fas fa-user mr-2"></i>
                                @endif
                            @else
                                <i class="fas fa-user mr-2"></i>
                            @endauth
                            Account
                            <i class="fas fa-chevron-down ml-2 text-sm group-hover:rotate-180 transition-transform"></i>
                        </button>
                        <div class="absolute top-full right-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2">
                            <div class="py-2">
                                @auth
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <div class="font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                        <div class="text-sm text-gray-500">{{ ucfirst(auth()->user()->role ?? 'student') }}</div>
                                    </div>
                                @endauth
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-600' : '' }}">
                                    <i class="fas fa-user text-blue-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">Profile</div>
                                        <div class="text-xs text-gray-500">Manage your profile</div>
                                    </div>
                                </a>
                                <a href="{{ route('settings') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-600 transition-colors {{ request()->routeIs('settings') ? 'bg-gray-50 text-gray-600' : '' }}">
                                    <i class="fas fa-cog text-gray-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">Settings</div>
                                        <div class="text-xs text-gray-500">Account preferences</div>
                                    </div>
                                </a>
                                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                                    <i class="fas fa-question-circle text-green-500 mr-3 w-4"></i>
                                    <div>
                                        <div class="font-medium">Help & Support</div>
                                        <div class="text-xs text-gray-500">Get assistance</div>
                                    </div>
                                </a>
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                            <i class="fas fa-sign-out-alt text-red-500 mr-3 w-4"></i>
                                            <div>
                                                <div class="font-medium">Logout</div>
                                                <div class="text-xs text-gray-500">Sign out of your account</div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="text-white/90 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                        <i class="fas fa-bars text-xl" id="mobile-menu-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="md:hidden bg-white/95 backdrop-blur-lg border-t border-white/20 absolute top-full left-0 right-0 shadow-xl opacity-0 invisible transition-all duration-300 transform -translate-y-4">
                <div class="px-4 py-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-home text-blue-500 mr-3 w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- Academic Section -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">Academic</div>
                        <a href="{{ route('courses.my-courses') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors {{ request()->routeIs('courses.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-book text-blue-500 mr-3 w-5"></i>
                            <span class="font-medium">My Courses</span>
                        </a>
                        <a href="{{ route('grades.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition-colors {{ request()->routeIs('grades.*') ? 'bg-green-50 text-green-600' : '' }}">
                            <i class="fas fa-chart-line text-green-500 mr-3 w-5"></i>
                            <span class="font-medium">CGPA Tracker</span>
                        </a>
                    </div>

                    <!-- Faculty Section -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">Faculty</div>
                        <a href="{{ route('faculty-reviews.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 rounded-lg transition-colors {{ request()->routeIs('faculty-reviews.*') ? 'bg-yellow-50 text-yellow-600' : '' }}">
                            <i class="fas fa-star text-yellow-500 mr-3 w-5"></i>
                            <span class="font-medium">Rate Faculty</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition-colors">
                            <i class="fas fa-download text-purple-500 mr-3 w-5"></i>
                            <span class="font-medium">Resources</span>
                        </a>
                    </div>

                    <!-- Account Section -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">Account</div>
                        <a href="{{ route('profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-user text-blue-500 mr-3 w-5"></i>
                            <span class="font-medium">Profile</span>
                        </a>
                        <a href="{{ route('settings') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-600 rounded-lg transition-colors {{ request()->routeIs('settings') ? 'bg-gray-50 text-gray-600' : '' }}">
                            <i class="fas fa-cog text-gray-500 mr-3 w-5"></i>
                            <span class="font-medium">Settings</span>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg transition-colors">
                            <i class="fas fa-question-circle text-green-500 mr-3 w-5"></i>
                            <span class="font-medium">Help & Support</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors">
                                <i class="fas fa-sign-out-alt text-red-500 mr-3 w-5"></i>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-blue-400 text-2xl"></i>
                        <h3 class="text-xl font-bold">Academic Hub</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed">
                        Revolutionizing university education through innovative technology solutions.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('courses.my-courses') }}" class="text-gray-300 hover:text-white transition-colors">My Courses</a></li>
                        <li><a href="{{ route('grades.index') }}" class="text-gray-300 hover:text-white transition-colors">CGPA Tracker</a></li>
                        <li><a href="{{ route('faculty-reviews.index') }}" class="text-gray-300 hover:text-white transition-colors">Faculty Reviews</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Documentation</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Contact</h3>
                    <div class="space-y-3 text-gray-300">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-blue-400"></i>
                            <span>info@academichub.edu</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-400"></i>
                            <span>+880 1XXX-XXXXXX</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="text-center text-gray-400 text-sm">
                    &copy; 2025 Academic Hub. All rights reserved. Made with ❤️ by <span class="text-blue-400 font-semibold">blackSquad</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle functionality
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('mobile-menu-icon');
            
            if (mobileMenu.classList.contains('opacity-0')) {
                // Show menu
                mobileMenu.classList.remove('opacity-0', 'invisible', '-translate-y-4');
                mobileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            } else {
                // Hide menu
                mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = event.target.closest('button[onclick="toggleMobileMenu()"]');
            
            if (!mobileMenu.contains(event.target) && !mobileMenuButton && !mobileMenu.classList.contains('opacity-0')) {
                toggleMobileMenu();
            }
        });

        // Close mobile menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                const mobileMenu = document.getElementById('mobile-menu');
                const menuIcon = document.getElementById('mobile-menu-icon');
                
                if (!mobileMenu.classList.contains('opacity-0')) {
                    mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            }
        });

        @yield('scripts')
    </script>
</body>
</html>
