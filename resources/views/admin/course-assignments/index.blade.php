<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Assignments - Academic Hub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        .sidebar-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            height: calc(100vh - 80px);
            width: 280px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 30;
            overflow-y: auto;
        }
        .sidebar.active {
            transform: translateX(0);
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
            margin-left: 0;
            padding-top: 80px;
            transition: margin-left 0.3s ease;
        }
        
        /* Desktop styles */
        @media (min-width: 1024px) {
            .sidebar {
                position: fixed;
                transform: translateX(0);
            }
            .main-content.sidebar-expanded {
                margin-left: 280px;
            }
            .main-content.sidebar-minimized {
                margin-left: 70px;
            }
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
                    <!-- Desktop Sidebar Toggle -->
                    <button onclick="toggleSidebar()" class="hidden lg:block text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/20 mr-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="navbar-brand lg:bg-white/20 flex items-center space-x-2">
                        <i class="fas fa-graduation-cap text-xl"></i>
                        <span>Academic Hub Admin</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="sm:block md:block lg:hidden xl:hidden text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/20 mr-2 border-2 border-white/50">
                        <i class="fas fa-bars text-xl" id="mobile-menu-icon"></i>
                    </button>
                    <a href="{{ route('profile') ?? '#' }}" class="flex items-center text-white/90 hover:text-white transition-colors group">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/20 group-hover:border-white/40 transition-colors">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar sidebar-bg">
        <div class="p-6">
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <i class="fas fa-home text-lg"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="#" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg bg-blue-100 text-blue-600 font-medium">
                    <i class="fas fa-chalkboard-teacher text-lg"></i>
                    <span class="sidebar-text">Course Assignments</span>
                </a>
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <i class="fas fa-users text-lg"></i>
                    <span class="sidebar-text">Manage Users</span>
                </a>
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <i class="fas fa-building text-lg"></i>
                    <span class="sidebar-text">Departments</span>
                </a>
                <a href="#" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-blue-50">
                    <i class="fas fa-graduation-cap text-lg"></i>
                    <span class="sidebar-text">Courses</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="mainContent" class="main-content p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Course Assignments</h1>
                <p class="text-gray-600">Assign faculty members to courses for different semesters</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Assignment Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Create New Assignment</h2>
                <form action="{{ route('admin.course-assignments.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @csrf
                    
                    <!-- Faculty Selection -->
                    <div>
                        <label for="faculty_id" class="block text-sm font-medium text-gray-700 mb-2">Faculty Member</label>
                        <select name="faculty_id" id="faculty_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Faculty</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->name }} ({{ $faculty->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Selection -->
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select name="course_id" id="course_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Year -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                        <select name="academic_year" id="academic_year" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>

                    <!-- Semester Type -->
                    <div>
                        <label for="semester_type" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                        <select name="semester_type" id="semester_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                            <option value="Fall">Fall</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Assign Course
                        </button>
                    </div>
                </form>
            </div>

            <!-- Current Assignments -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Current Assignments</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assignments as $assignment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $assignment->faculty->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $assignment->faculty->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $assignment->course->course_code }}</div>
                                        <div class="text-sm text-gray-500">{{ $assignment->course->course_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $assignment->semester }}</div>
                                        <div class="text-sm text-gray-500">{{ $assignment->course->credits }} Credits</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($assignment->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('admin.course-assignments.destroy', $assignment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this assignment?')">
                                                <i class="fas fa-trash mr-1"></i>Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No course assignments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($assignments->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $assignments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer" class="bg-gray-800 text-white py-12 footer-margin">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">About Academic Hub</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Comprehensive academic management system for administrators, faculty, and students.
                    </p>
                </div>

                <!-- Admin Features -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Admin Features</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-chalkboard-teacher text-blue-400 mr-2"></i>
                            Course Assignments
                        </li>
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-users text-blue-400 mr-2"></i>
                            User Management
                        </li>
                        <li class="text-gray-300 flex items-center">
                            <i class="fas fa-building text-blue-400 mr-2"></i>
                            Department Management
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Dashboard</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">Course Assignments</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">Manage Users</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white">Contact</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-university text-blue-400 mr-3"></i>
                            <span>Daffodil International University</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-envelope text-blue-400 mr-3"></i>
                            <span>admin@diu.edu.bd</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Academic Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        let isMinimized = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function toggleSidebarSize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const footer = document.getElementById('footer');
            
            isMinimized = !isMinimized;
            
            if (isMinimized) {
                sidebar.classList.add('minimized');
                mainContent.classList.remove('sidebar-expanded');
                mainContent.classList.add('sidebar-minimized');
                footer.classList.remove('sidebar-expanded');
                footer.classList.add('sidebar-minimized');
            } else {
                sidebar.classList.remove('minimized');
                mainContent.classList.remove('sidebar-minimized');
                mainContent.classList.add('sidebar-expanded');
                footer.classList.remove('sidebar-minimized');
                footer.classList.add('sidebar-expanded');
            }
            
            localStorage.setItem('sidebarMinimized', isMinimized);
        }

        function toggleMobileMenu() {
            // Mobile menu functionality can be added here
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 1024) {
                const mainContent = document.getElementById('mainContent');
                const footer = document.getElementById('footer');
                mainContent.classList.add('sidebar-expanded');
                footer.classList.add('sidebar-expanded');
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
                mainContent.classList.remove('sidebar-expanded', 'sidebar-minimized');
                footer.classList.remove('sidebar-expanded', 'sidebar-minimized');
            }
        });
    </script>
</body>
</html>
