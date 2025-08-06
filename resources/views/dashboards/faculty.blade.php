<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - Academic Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-white text-xl font-bold">Academic Hub</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">Welcome, {{ $user->name ?? 'Faculty' }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Faculty Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ $user->name ?? 'Faculty' }}!</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Reviews -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-star text-yellow-400 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Reviews</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['total_reviews'] ?? 0 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Rating -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-thumbs-up text-green-400 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Average Rating</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['average_rating'] ?? 4.5, 1) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Taught -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-book text-blue-400 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Courses Taught</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['courses_taught'] ?? 3 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Taught -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-purple-400 text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Students Taught</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['students_taught'] ?? 156 }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Courses -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Your Courses</h3>
            </div>
            <div class="px-6 py-4">
                @if(isset($assigned_courses) && $assigned_courses->count() > 0)
                    <div class="grid gap-4">
                        @foreach($assigned_courses as $course)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold">{{ $course['code'] ?? 'CSE 101' }}</h4>
                                <p class="text-gray-600">{{ $course['name'] ?? 'Sample Course' }}</p>
                                <div class="mt-2 flex space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-users"></i> {{ $course['students'] ?? 45 }} students</span>
                                    <span><i class="fas fa-star"></i> {{ $course['rating'] ?? '4.5' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">You don't have any assigned courses yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; 2025 Academic Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
