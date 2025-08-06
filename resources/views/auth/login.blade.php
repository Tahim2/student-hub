<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Academic Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }
        .form-floating input {
            padding: 1rem 0.75rem;
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .form-floating input:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-floating input::placeholder {
            color: transparent;
        }
        .form-floating label {
            position: absolute;
            top: 1rem;
            left: 0.75rem;
            color: #64748b;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
            background-color: transparent;
            z-index: 1;
        }
        .form-floating input:focus + label,
        .form-floating input:not(:placeholder-shown) + label,
        .form-floating input:valid + label {
            top: -0.5rem;
            left: 0.5rem;
            font-size: 0.75rem;
            color: #3b82f6;
            background-color: #ffffff;
            padding: 0 0.25rem;
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-feature {
            transition: all 0.3s ease;
        }
        .login-feature:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <h1 class="text-white text-xl font-bold">Academic Hub</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Register link removed -->
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Login Form -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 animate-fade-in">
                    <div class="text-center mb-8">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-sign-in-alt text-blue-600 text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                        <p class="text-gray-600">Sign in to your Academic Hub account</p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="form-floating">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="w-full px-3 py-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                   placeholder=" "
                                   value="{{ old('email') }}"
                                   required>
                            <label for="email" class="text-gray-500">Email Address</label>
                            @error('email')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="w-full px-3 py-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                                   placeholder=" "
                                   required>
                            <label for="password" class="text-gray-500">Password</label>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="remember" 
                                       name="remember" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                            </div>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Forgot password?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </form>

                    <!-- OR Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-600 font-medium">or continue with</span>
                        </div>
                    </div>

                    <!-- Google Login Button -->
                    <a href="{{ route('google.login') }}" 
                       class="w-full bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold py-4 px-6 rounded-lg transition-colors flex items-center justify-center shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                        Continue with Google
                    </a>

                    <!-- Register Link -->
                    <div class="text-center mt-6">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>
                        </p>
                    </div>

                    <!-- Quick Access -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Quick Access:</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <button class="text-xs text-gray-600 hover:text-blue-600 text-left">Demo Student</button>
                            <button class="text-xs text-gray-600 hover:text-blue-600 text-left">Demo Faculty</button>
                        </div>
                    </div>
                </div>

                <!-- Features Sidebar -->
                <div class="text-white space-y-8 animate-fade-in" style="animation-delay: 0.3s;">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Access Your Academic World</h3>
                        <p class="text-white/90 mb-8">
                            Sign in to explore faculty reviews, access academic resources, and track your CGPA progress.
                        </p>
                    </div>

                    <div class="space-y-6">
                        <div class="login-feature flex items-start space-x-4">
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-star text-yellow-300 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg">Faculty Reviews</h4>
                                <p class="text-white/80 text-sm">Read and write reviews for faculty members across different courses</p>
                            </div>
                        </div>

                        <div class="login-feature flex items-start space-x-4">
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-cloud-download-alt text-blue-300 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg">Resource Library</h4>
                                <p class="text-white/80 text-sm">Access notes, past papers, and study materials from Google Drive</p>
                            </div>
                        </div>

                        <div class="login-feature flex items-start space-x-4">
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-chart-line text-green-300 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg">CGPA Tracker</h4>
                                <p class="text-white/80 text-sm">Monitor your academic progress with automated CGPA calculations</p>
                            </div>
                        </div>

                        <div class="login-feature flex items-start space-x-4">
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-users text-purple-300 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg">Student Community</h4>
                                <p class="text-white/80 text-sm">Connect with fellow students and share academic experiences</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/10 rounded-lg p-6 backdrop-blur-md">
                        <h4 class="font-semibold mb-2">🎓 For Students</h4>
                        <p class="text-white/80 text-sm mb-4">Review faculty, access resources, track grades</p>
                        <h4 class="font-semibold mb-2">👨‍🏫 For Faculty</h4>
                        <p class="text-white/80 text-sm mb-4">View reviews, verify profiles, engage with students</p>
                        <h4 class="font-semibold mb-2">🛡️ For Admins</h4>
                        <p class="text-white/80 text-sm">Manage platform, moderate content, oversee system</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
                <!-- Register link removed -->
            </div>
        </div>
    </section>
    <footer class="bg-primary dark:bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center">
                <h3 class="text-xl font-bold mb-2 tracking-tight">Academic Hub</h3>
                <p class="text-sm mb-4">Empowering your academic journey</p>
            </div>
            <div class="mt-6 text-center text-sm">
                <p>© 2025 Academic Hub. Made by blackSquad. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('email').addEventListener('input', function(e) {
            const email = e.target.value;
            if (email && !email.endsWith('@diu.edu.bd')) {
                e.target.setCustomValidity('Email must end with @diu.edu.bd');
                e.target.style.borderColor = '#ef4444';
            } else {
                e.target.setCustomValidity('');
                e.target.style.borderColor = '#1E40AF';
            }
        });
    </script>
</body>
</html>
