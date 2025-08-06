<!DOCTYPE html>
<html lang="en" class="dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-50 dark:bg-gray-900 font-sans flex flex-col min-h-screen transition-colors duration-300">
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

    <!-- Interactive User Profile Page -->
    <section class="flex-grow py-16 bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-700">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-extrabold text-center mb-12 text-primary dark:text-white animate-fade-in">User Profile</h2>
            <div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg animate-slide-up">
                <form method="POST" action="{{ route('user-profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative w-28 h-28 mb-2">
                            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1E40AF&color=fff' }}" alt="Profile Picture" class="w-28 h-28 rounded-full object-cover border-4 border-primary dark:border-gray-600">
                            <label for="profile_picture" class="absolute bottom-0 right-0 bg-secondary text-white p-2 rounded-full cursor-pointer shadow-lg">
                                <!-- Pen icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2a2.828 2.828 0 11-4-4 2.828 2.828 0 014 4zM19 20H5a2 2 0 01-2-2V7a2 2 0 012-2h7"></path></svg>
                                <input id="profile_picture" name="profile_picture" type="file" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Click to change profile picture</span>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Name</label>
                        <input type="text" name="name" class="w-full p-3 border-2 border-primary rounded-lg focus:outline-none focus:border-secondary transition dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
                        <input type="email" class="w-full p-3 border-2 border-primary rounded-lg bg-gray-100 dark:bg-gray-600 cursor-not-allowed dark:text-gray-300" value="{{ Auth::user()->email }}" disabled>
                        <small class="text-gray-600 dark:text-gray-400">University email addresses (@diu.edu.bd) cannot be changed</small>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Role</label>
                        <input type="text" class="w-full p-3 border-2 border-primary rounded-lg bg-gray-100 dark:bg-gray-600 cursor-not-allowed dark:text-gray-300" value="{{ Auth::user()->role ?? 'Student' }}" disabled>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-secondary transition transform hover:scale-105 shadow-lg dark:bg-gray-700 dark:hover:bg-yellow-400">Update Profile</button>
                </form>
                <div class="mt-6 flex justify-between">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition dark:text-red-400 dark:hover:text-red-300">Log Out</button>
                    </form>
                    <button type="button" class="text-accent hover:text-green-700 font-medium transition dark:text-green-400 dark:hover:text-green-300" onclick="document.getElementById('activity-modal').classList.remove('hidden')">View Activity</button>
            <!-- Activity Modal -->
            <div id="activity-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-lg relative">
                    <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" onclick="document.getElementById('activity-modal').classList.add('hidden')">&times;</button>
                    <h3 class="text-2xl font-bold mb-4 text-primary dark:text-white">Recent Activity</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-primary rounded-full mr-2"></span>
                            <span>Logged in</span>
                            <span class="ml-auto text-xs text-gray-400">{{ Auth::user()->last_login_at ?? 'Just now' }}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-secondary rounded-full mr-2"></span>
                            <span>Profile updated</span>
                            <span class="ml-auto text-xs text-gray-400">{{ Auth::user()->updated_at->diffForHumans() }}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-accent rounded-full mr-2"></span>
                            <span>Submitted a faculty review</span>
                            <span class="ml-auto text-xs text-gray-400">Recently</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Activity Modal -->
            <div id="activity-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-lg relative">
                    <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" onclick="document.getElementById('activity-modal').classList.add('hidden')">&times;</button>
                    <h3 class="text-2xl font-bold mb-4 text-primary dark:text-white">Recent Activity</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-primary rounded-full mr-2"></span>
                            <span>Logged in</span>
                            <span class="ml-auto text-xs text-gray-400">{{ Auth::user()->last_login_at ?? 'Just now' }}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-secondary rounded-full mr-2"></span>
                            <span>Profile updated</span>
                            <span class="ml-auto text-xs text-gray-400">{{ Auth::user()->updated_at->diffForHumans() }}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="inline-block w-2 h-2 bg-accent rounded-full mr-2"></span>
                            <span>Submitted a faculty review</span>
                            <span class="ml-auto text-xs text-gray-400">Recently</span>
                        </li>
                    </ul>
                </div>
            </div>
                </div>
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
</body>
</html>
