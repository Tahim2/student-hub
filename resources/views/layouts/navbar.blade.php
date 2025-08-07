<!-- Responsive Navbar -->
<nav class="bg-primary dark:bg-gray-800 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">UniHub</a>
        <div class="hidden md:flex space-x-6 items-center">
            <a href="{{ route('home') }}" class="hover:text-secondary transition duration-300 {{ request()->routeIs('home') ? 'text-secondary' : '' }}">Home</a>
            <a href="{{ route('faculty-reviews') }}" class="hover:text-secondary transition duration-300 {{ request()->routeIs('faculty-reviews') ? 'text-secondary' : '' }}">Faculty Reviews</a>
            <a href="{{ route('resource-hub') }}" class="hover:text-secondary transition duration-300 {{ request()->routeIs('resource-hub') ? 'text-secondary' : '' }}">Resource Hub</a>
            <a href="{{ route('cgpa-tracker') }}" class="hover:text-secondary transition duration-300 {{ request()->routeIs('cgpa-tracker') ? 'text-secondary' : '' }}">CGPA Tracker</a>
            <a href="{{ route('dashboard') }}" class="hover:text-secondary transition duration-300 {{ request()->routeIs('dashboard') ? 'text-secondary' : '' }}">Dashboard</a>
            
            <!-- Settings Dropdown -->
            <div class="relative">
                <button id="settings-toggle" class="p-2 rounded-full hover:bg-secondary transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
                <div id="settings-dropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-600 z-50 hidden">
                    <div class="py-2">
                        @auth
                            <a href="{{ route('user-profile') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Settings
                            </a>
                            <button id="dark-mode-toggle" class="flex items-center w-full px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition text-left">
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="dark:hidden">Dark Mode</span>
                                <span class="hidden dark:block">Light Mode</span>
                            </button>
                            <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 12v5h5l-5-5zM4 7V2l5 5H4z"></path>
                                </svg>
                                Notifications
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Privacy
                            </a>
                            <hr class="my-2 border-gray-200 dark:border-gray-600">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 transition text-left">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login
                            </a>
                            <!-- Register link removed -->
                                <svg class="w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <!-- Register text removed -->
                            </a>
                        @endauth
                    </div>
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
        <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Home</a>
        <a href="{{ route('faculty-reviews') }}" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Faculty Reviews</a>
        <a href="{{ route('resource-hub') }}" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Resource Hub</a>
        <a href="{{ route('cgpa-tracker') }}" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">CGPA Tracker</a>
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-secondary hover:text-white transition duration-300">Dashboard</a>
    </div>
</nav>
