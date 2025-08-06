<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Academic Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up {
            animation: slideUp 0.8s ease-in-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h1 class="text-white text-xl font-bold">Academic Hub</h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <main class="container mx-auto px-6 py-16 text-center text-white">
        <div class="animate-fade-in">
            <h2 class="text-5xl md:text-6xl font-bold mb-6">Welcome to Academic Hub!</h2>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Your comprehensive platform for faculty reviews, academic resources, and CGPA tracking.</p>
            
            <!-- CTA Button -->
            <div class="mb-12">
                <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full text-lg font-semibold hover:bg-blue-50 transition transform hover:scale-105 inline-flex items-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Sign Up</span>
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-blue-600 transition transform hover:scale-105 inline-flex items-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Feature Cards -->
    <section class="py-16 bg-white/10 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Faculty Reviews Card -->
                <div class="bg-white/20 backdrop-blur-md p-8 rounded-xl text-center text-white card-hover animate-slide-up">
                    <div class="mb-6">
                        <i class="fas fa-star text-4xl text-yellow-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Faculty Reviews</h3>
                    <p class="text-white/80 mb-6">Rate and review faculty members based on specific courses. Help fellow students make informed decisions.</p>
                </div>

                <!-- Resource Hub Card -->
                <div class="bg-white/20 backdrop-blur-md p-8 rounded-xl text-center text-white card-hover animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="mb-6">
                        <i class="fas fa-folder-open text-4xl text-green-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Resource Hub</h3>
                    <p class="text-white/80 mb-6">Access and share course materials, notes, past papers, and study guides with the DIU community.</p>
                </div>

                <!-- CGPA Tracker Card -->
                <div class="bg-white/20 backdrop-blur-md p-8 rounded-xl text-center text-white card-hover animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="mb-6">
                        <i class="fas fa-chart-line text-4xl text-purple-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">CGPA Tracker</h3>
                    <p class="text-white/80 mb-6">Monitor your academic progress with our intuitive CGPA calculator and semester-wise analysis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="text-center text-white mb-12">
                <h2 class="text-4xl font-bold mb-4 animate-fade-in">Get Started Today</h2>
                <p class="text-xl opacity-90 animate-fade-in">Join thousands of students enhancing their academic journey</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl mx-auto">
                <a href="{{ route('login') }}" class="bg-white/20 backdrop-blur-md p-8 rounded-xl text-center text-white hover:bg-white/30 transition-all transform hover:scale-105 animate-slide-up">
                    <i class="fas fa-sign-in-alt text-4xl text-blue-300 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Login</h3>
                    <p class="text-white/80 text-sm">Access your existing account</p>
                </a>
                <a href="{{ route('register') }}" class="bg-white/20 backdrop-blur-md p-8 rounded-xl text-center text-white hover:bg-white/30 transition-all transform hover:scale-105 animate-slide-up" style="animation-delay: 0.1s;">
                    <i class="fas fa-user-plus text-4xl text-green-300 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Sign Up</h3>
                    <p class="text-white/80 text-sm">Create your new account</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black/20 backdrop-blur-md border-t border-white/20 py-8">
        <div class="container mx-auto px-6">
            <div class="text-center text-white">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-white/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <span class="text-lg font-semibold">Academic Hub</span>
                </div>
                <p class="text-white/60 text-sm">© 2025 Academic Hub. Enhancing university education through technology.</p>
            </div>
        </div>
    </footer>
</body>
</html>
