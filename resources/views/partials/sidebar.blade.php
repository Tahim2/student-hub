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
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3">
                <i class="fas fa-home text-lg"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
            
            @if(($user->role ?? 'student') === 'student')
                <a href="{{ route('courses.my-courses') }}" class="sidebar-item {{ request()->routeIs('courses.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3">
                    <i class="fas fa-book text-lg"></i>
                    <span class="sidebar-text">My Courses</span>
                </a>
                <a href="{{ route('grades.index') }}" class="sidebar-item {{ request()->routeIs('grades.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3">
                    <i class="fas fa-chart-line text-lg"></i>
                    <span class="sidebar-text">Grades</span>
                </a>
                <a href="{{ route('faculty-reviews.index') }}" class="sidebar-item {{ request()->routeIs('faculty-reviews.*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3">
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
                <a href="{{ route('profile') }}" class="sidebar-item {{ request()->routeIs('profile*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3">
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
                <a href="{{ route('settings') }}" class="sidebar-item {{ request()->routeIs('settings') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3">
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
