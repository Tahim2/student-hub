<!-- Route definition code removed to ensure only HTML/Blade/JS is present -->
<!DOCTYPE html>
<html lang="en" class="dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://apis.google.com/js/api.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        secondary: '#F59E0B',
                        accent: '#10B981',
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(20px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans flex flex-col min-h-screen transition-colors duration-300">
    <!-- Responsive Navbar -->
    <nav class="bg-primary dark:bg-gray-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold tracking-tight">UniHub</a>
            <div class="hidden md:flex space-x-6 items-center">
                <a href="/" class="hover:text-secondary transition duration-300">Home</a>
                <a href="/faculty-reviews" class="hover:text-secondary transition duration-300">Faculty Reviews</a>
                <a href="/resource-hub" class="hover:text-secondary transition duration-300">Resource Hub</a>
                <a href="/cgpa-tracker" class="hover:text-secondary transition duration-300">CGPA Tracker</a>
                <a href="/dashboard" class="hover:text-secondary transition duration-300">Dashboard</a>
                <!-- Settings Dropdown -->
                <div class="relative group">
                    <button class="p-2 rounded-full hover:bg-secondary transition flex items-center" id="settings-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-xl shadow-lg py-2 z-50 hidden group-hover:block" id="settings-dropdown">
                        <a href="/user-profile" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Profile
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 transition" id="dark-mode-toggle">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            Dark Mode
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            Notifications
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Privacy
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 w-full text-left text-red-600 hover:bg-gray-100 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" /></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <button class="md:hidden focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-primary dark:bg-gray-800 transition-all duration-300 ease-in-out">
            <a href="/" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Home</a>
            <a href="/faculty-reviews" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Faculty Reviews</a>
            <a href="/resource-hub" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Resource Hub</a>
            <a href="/cgpa-tracker" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">CGPA Tracker</a>
            <a href="/dashboard" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Dashboard</a>
            <!-- Settings Dropdown for mobile (simple link) -->
            <a href="/user-profile" class="block px-4 py-2 hover:bg-gray-100 transition">Settings</a>
        </div>
    </nav>

    <!-- Resource Hub Section -->
    <section class="flex-grow py-16 bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-700">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-extrabold text-center mb-12 text-primary dark:text-white animate-fade-in">Resource Hub</h2>
            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg animate-slide-up">
                <!-- Google Sign-In -->
                <div id="g-signin" class="mb-6">
                    <button id="sign-in-btn" class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition transform hover:scale-105">Sign in with Google</button>
                </div>
                <!-- Resource Upload Form -->
                <div id="resource-upload" class="mb-8 hidden">
                    <!-- ...existing code... -->
                </div>
                <!-- Resource Browser -->
                <div id="resource-browser" class="mb-8">
                    <!-- ...existing code... -->
                </div>
                <!-- Admin Moderation -->
                <div id="admin-moderation" class="hidden">
                    <!-- ...existing code... -->
                </div>
                <button id="toggle-admin" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Show Admin Panel</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary dark:bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center">
                <h3 class="text-xl font-bold mb-2 tracking-tight">UniHub</h3>
                <p class="text-sm mb-4">Empowering your academic journey</p>
            </div>
            <div class="mt-6 text-center text-sm">
                <p>© 2025 UniHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Settings dropdown script -->
    <script>
        // Settings dropdown functionality
        const settingsToggle = document.getElementById('settings-toggle');
        const settingsDropdown = document.getElementById('settings-dropdown');
        if (settingsToggle && settingsDropdown) {
            settingsToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                settingsDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!settingsDropdown.classList.contains('hidden')) {
                    settingsDropdown.classList.add('hidden');
                }
            });
            settingsDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
        
        // Dark mode toggle
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', function(e) {
                e.preventDefault();
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            });
            // Apply saved theme on page load
            if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
        }
    </script>
    <!-- ...existing JS code... -->
</body>
</html>
