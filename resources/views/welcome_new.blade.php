<!DOCTYPE html>
<html lang="en" class="dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Hub - DIU Academic Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#0ea5e9',
                        secondary: '#0284c7',
                        accent: '#10B981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-b from-blue-100 to-blue-200 dark:from-gray-900 dark:to-gray-800 font-sans flex flex-col min-h-screen transition-colors duration-300">

    <!-- Navigation Bar -->
    <nav class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Academic Hub</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    @guest
                        <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Features</a>
                        <a href="#about" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">About</a>
                        <a href="{{ route('faculty-reviews') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Faculty Reviews</a>
                        <a href="{{ route('resource-hub') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Resources</a>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Login</a>
                            <a href="{{ route('register') }}" class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-full transition">Sign Up</a>
                        </div>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Dashboard</a>
                        <a href="{{ route('courses.my-courses') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">My Courses</a>
                        <a href="{{ route('faculty-reviews') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Reviews</a>
                        <a href="{{ route('resource-hub') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Resources</a>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('user-profile') }}" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">
                                @if(auth()->user()->profile_picture ?? null)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-700 transition">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endguest
                    
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:block"></i>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                <div class="px-4 py-2 space-y-2">
                    @guest
                        <a href="#features" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Features</a>
                        <a href="#about" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">About</a>
                        <a href="{{ route('faculty-reviews') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Faculty Reviews</a>
                        <a href="{{ route('resource-hub') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Resources</a>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                            <a href="{{ route('login') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">Login</a>
                            <a href="{{ route('register') }}" class="block py-2 bg-primary text-white text-center rounded-lg hover:bg-secondary transition">Sign Up</a>
                        </div>
                    @else
                        <a href="{{ route('dashboard') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('courses.my-courses') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">
                            <i class="fas fa-book mr-2"></i>My Courses
                        </a>
                        <a href="{{ route('faculty-reviews') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">
                            <i class="fas fa-star mr-2"></i>Reviews
                        </a>
                        <a href="{{ route('resource-hub') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">
                            <i class="fas fa-folder mr-2"></i>Resources
                        </a>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                            <a href="{{ route('user-profile') }}" class="block py-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="w-full text-left py-2 text-red-600 hover:text-red-700 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex-grow min-h-screen bg-gradient-to-br from-primary to-indigo-700 flex flex-col justify-center items-center text-white relative pt-16">
        <header class="text-center px-4 relative z-10">
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold mb-6 tracking-tight">Welcome to <span class="text-yellow-300">Academic Hub</span></h1>
            <p class="text-lg sm:text-xl md:text-2xl mb-4 max-w-3xl mx-auto">Your Ultimate DIU Academic Platform</p>
            <p class="text-base sm:text-lg md:text-xl mb-10 max-w-4xl mx-auto opacity-90">Faculty reviews, shared resources, and CGPA tracking - all in one place. Join thousands of DIU students enhancing their academic journey!</p>
            
            <!-- Call-to-Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                @guest
                    <a href="{{ route('register') }}" class="bg-yellow-300 hover:bg-yellow-400 text-gray-900 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold transition transform hover:scale-105">
                        <i class="fas fa-rocket mr-2"></i>Get Started - Sign Up
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-primary text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold transition">
                        Already have an account? Login
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-yellow-300 hover:bg-yellow-400 text-gray-900 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold transition transform hover:scale-105">
                        <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                    </a>
                    <a href="{{ route('courses.my-courses') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-primary text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold transition">
                        <i class="fas fa-book mr-2"></i>My Courses
                    </a>
                @endguest
            </div>
            
            <!-- Quick Stats Preview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-xl sm:text-2xl font-bold text-yellow-300">1,234</div>
                    <div class="text-xs sm:text-sm opacity-80">Students</div>
                </div>
                <div class="text-center">
                    <div class="text-xl sm:text-2xl font-bold text-yellow-300">2,567</div>
                    <div class="text-xs sm:text-sm opacity-80">Reviews</div>
                </div>
                <div class="text-center">
                    <div class="text-xl sm:text-2xl font-bold text-yellow-300">1,890</div>
                    <div class="text-xs sm:text-sm opacity-80">Resources</div>
                </div>
                <div class="text-center">
                    <div class="text-xl sm:text-2xl font-bold text-yellow-300">150+</div>
                    <div class="text-xs sm:text-sm opacity-80">Faculty</div>
                </div>
            </div>
        </header>
    </section>

    <!-- Feature Showcase -->
    <section id="features" class="py-12 sm:py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-4 text-primary dark:text-white">Why Choose Academic Hub?</h2>
            <p class="text-center text-gray-600 dark:text-gray-300 mb-8 sm:mb-12 max-w-2xl mx-auto">Everything you need to excel in your academic journey, powered by student collaboration and real experiences.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <!-- Faculty Reviews -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700 p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="text-center">
                        <div class="bg-primary text-white w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-star text-lg sm:text-2xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-primary dark:text-blue-400">Faculty Reviews</h3>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-4">Discover what students say about professors and courses. Make informed decisions for your academic journey.</p>
                        
                        <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span class="font-semibold text-accent">500+</span> Reviews • <span class="font-semibold text-accent">150+</span> Faculty
                        </div>
                        <a href="{{ route('faculty-reviews') }}" class="bg-primary text-white px-4 sm:px-6 py-2 rounded-full hover:bg-blue-700 transition inline-block text-sm sm:text-base">Browse Reviews</a>
                    </div>
                </div>

                <!-- Resource Hub -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-800 dark:to-gray-700 p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="text-center">
                        <div class="bg-accent text-white w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-folder text-lg sm:text-2xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-accent dark:text-green-400">Resource Hub</h3>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-4">Access course materials, notes, past papers, and study guides shared by the DIU community.</p>
                        
                        <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span class="font-semibold text-accent">1,000+</span> Resources • <span class="font-semibold text-accent">50+</span> Courses
                        </div>
                        <a href="{{ route('resource-hub') }}" class="bg-accent text-white px-4 sm:px-6 py-2 rounded-full hover:bg-green-700 transition inline-block text-sm sm:text-base">Explore Resources</a>
                    </div>
                </div>

                <!-- CGPA Tracker -->
                <div class="bg-gradient-to-br from-yellow-50 to-orange-100 dark:from-gray-800 dark:to-gray-700 p-6 sm:p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="text-center">
                        <div class="bg-yellow-500 text-white w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-line text-lg sm:text-2xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-semibold mb-4 text-yellow-600 dark:text-yellow-400">CGPA Tracker</h3>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-4">Monitor your academic progress with our intuitive CGPA calculator and semester tracking.</p>
                        
                        <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Track <span class="font-semibold text-yellow-600">GPA</span> • <span class="font-semibold text-yellow-600">Semester</span> Analysis
                        </div>
                        <a href="{{ route('grades.index') }}" class="bg-yellow-500 text-white px-4 sm:px-6 py-2 rounded-full hover:bg-yellow-600 transition inline-block text-sm sm:text-base">Start Tracking</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-12 sm:py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-primary dark:text-white">About Academic Hub</h2>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300 mb-8">Academic Hub is designed by students, for students. We understand the challenges of university life and created a platform that brings together all the resources you need to succeed academically.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mt-8 sm:mt-12">
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg">
                        <div class="text-primary dark:text-blue-400 mb-4">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold mb-3 text-gray-900 dark:text-white">Student Community</h3>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">Connect with fellow DIU students, share experiences, and learn from each other's academic journey.</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg">
                        <div class="text-accent dark:text-green-400 mb-4">
                            <i class="fas fa-shield-alt text-3xl"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold mb-3 text-gray-900 dark:text-white">Trusted Reviews</h3>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">All reviews are verified and moderated to ensure authentic, helpful feedback for the community.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Stats -->
    <section class="py-12 sm:py-16 bg-blue-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-8 sm:mb-12 text-primary dark:text-white">Join Our Growing Community</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-8 text-center">
                <div class="bg-white dark:bg-gray-700 p-4 sm:p-6 rounded-xl shadow-lg">
                    <div class="text-2xl sm:text-4xl font-bold text-primary dark:text-blue-400 mb-2">1,234</div>
                    <div class="text-xs sm:text-base text-gray-600 dark:text-gray-300">Active Students</div>
                </div>
                <div class="bg-white dark:bg-gray-700 p-4 sm:p-6 rounded-xl shadow-lg">
                    <div class="text-2xl sm:text-4xl font-bold text-accent dark:text-green-400 mb-2">2,567</div>
                    <div class="text-xs sm:text-base text-gray-600 dark:text-gray-300">Total Reviews</div>
                </div>
                <div class="bg-white dark:bg-gray-700 p-4 sm:p-6 rounded-xl shadow-lg">
                    <div class="text-2xl sm:text-4xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">1,890</div>
                    <div class="text-xs sm:text-base text-gray-600 dark:text-gray-300">Resources Shared</div>
                </div>
                <div class="bg-white dark:bg-gray-700 p-4 sm:p-6 rounded-xl shadow-lg">
                    <div class="text-2xl sm:text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">150+</div>
                    <div class="text-xs sm:text-base text-gray-600 dark:text-gray-300">Faculty Members</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white py-8 sm:py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap text-white text-lg sm:text-xl"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold tracking-tight">Academic Hub</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-300 mb-6 max-w-md mx-auto">Empowering DIU students through collaboration, shared knowledge, and academic excellence. Your success is our mission.</p>
                
                <div class="border-t border-gray-800 pt-6">
                    <div class="text-center">
                        <p class="text-gray-400 text-xs sm:text-sm">© 2025 Academic Hub. All rights reserved.</p>
                        <p class="text-gray-500 text-xs sm:text-sm mt-2">Made with ❤️ for DIU Students</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        // Check for saved theme preference or default to light
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
        }

        themeToggle.addEventListener('click', function() {
            html.classList.toggle('dark');
            
            // Save theme preference
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            });
        });

        // Apply saved theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        });
    </script>
</body>
</html>
