<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Faculty Portal - Academic Hub')</title>
    
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
    
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Faculty Navigation -->
    <nav class="gradient-bg shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('faculty.dashboard') }}" class="flex items-center space-x-2 text-white hover:text-white/90 transition-colors">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        <span class="text-xl font-bold">Faculty Portal</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('faculty.dashboard') }}" class="text-white hover:text-white/80 transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('faculty.courses') }}" class="text-white hover:text-white/80 transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="{{ route('profile') }}" class="text-white hover:text-white/80 transition-colors font-medium flex items-center space-x-1">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileDropdown" class="flex items-center space-x-2 text-white hover:text-white/80 transition-colors">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <span class="hidden md:block">{{ Auth::user()->name ?? 'Faculty' }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    
                    <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobileMenuButton" class="text-white hover:text-white/80 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobileMenu" class="md:hidden hidden bg-white/10 backdrop-blur-sm">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('faculty.dashboard') }}" class="block px-3 py-2 text-white hover:bg-white/10 rounded-md transition-colors">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('faculty.courses') }}" class="block px-3 py-2 text-white hover:bg-white/10 rounded-md transition-colors">
                        <i class="fas fa-book mr-2"></i>My Courses
                    </a>
                    <a href="{{ route('profile') }}" class="block px-3 py-2 text-white hover:bg-white/10 rounded-md transition-colors">
                        <i class="fas fa-user mr-2"></i>Profile
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-white hover:bg-white/10 rounded-md transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-white hover:bg-white/10 rounded-md transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-chalkboard-teacher text-2xl text-blue-400"></i>
                        <span class="text-xl font-bold">Faculty Portal</span>
                    </div>
                    <p class="text-gray-300 mb-4">
                        Empowering educators with modern tools for course management and student engagement.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('faculty.dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('faculty.courses') }}" class="text-gray-300 hover:text-white transition-colors">My Courses</a></li>
                        <li><a href="{{ route('profile') }}" class="text-gray-300 hover:text-white transition-colors">Profile</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact IT</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Documentation</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-6 mt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Academic Hub - Faculty Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Profile dropdown functionality
        document.getElementById('profileDropdown').addEventListener('click', function() {
            const menu = document.getElementById('profileDropdownMenu');
            menu.classList.toggle('hidden');
        });

        // Mobile menu functionality
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileMenu = document.getElementById('profileDropdownMenu');
            const mobileButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');

            if (!profileDropdown.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }

            if (!mobileButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
