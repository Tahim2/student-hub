<!DOCTYPE html>
<html lang="en" class="dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review - UniHub</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans flex flex-col min-h-screen transition-colors duration-300">
    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <div class="flex-grow py-8">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-full p-3">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Write Review for {{ $faculty->user->name }}</h1>
                        <p class="text-gray-600 dark:text-gray-300">{{ $faculty->designation }}, {{ $faculty->department->name }}</p>
                    </div>
                </div>

                @if($existingReview)
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                    You have already reviewed this faculty member
                                </h3>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                    You reviewed them for {{ $existingReview->course->course_name }} with a {{ $existingReview->rating }}-star rating.
                                    <a href="{{ route('reviews.edit', $existingReview) }}" class="underline font-medium">Edit your review</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if(!$existingReview || !$selectedCourse)
                <!-- Review Form -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="faculty_id" value="{{ $faculty->id }}">

                        <!-- Course Selection -->
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select name="course_id" id="course_id" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                                <option value="">Select the course you took with this faculty</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $selectedCourse && $selectedCourse->id == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_code }} - {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1" id="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" class="star-btn text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors duration-200" data-rating="{{ $i }}">
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <span id="rating-text" class="text-sm text-gray-600 dark:text-gray-400 ml-4"></span>
                            </div>
                            <input type="hidden" name="rating" id="rating-input" required>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Semester -->
                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Semester Taken <span class="text-red-500">*</span>
                            </label>
                            <select name="semester" id="semester" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                                <option value="">Select semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->name }}">{{ $semester->name }}</option>
                                @endforeach
                                <option value="Fall 2024">Fall 2024</option>
                                <option value="Spring 2024">Spring 2024</option>
                                <option value="Summer 2024">Summer 2024</option>
                            </select>
                            @error('semester')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Review Text -->
                        <div>
                            <label for="review_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Review
                            </label>
                            <textarea name="review_text" id="review_text" rows="4" maxlength="1000"
                                      placeholder="Share your experience with this faculty member... (Optional)"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none">{{ old('review_text') }}</textarea>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Optional - Help other students by sharing your experience</span>
                                <span class="text-xs text-gray-500" id="char-count">0/1000</span>
                            </div>
                            @error('review_text')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Anonymous Option -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="is_anonymous" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Submit this review anonymously
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('faculty.show', $faculty->id) }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="submit-btn" disabled>
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starButtons = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('rating-input');
            const ratingText = document.getElementById('rating-text');
            const submitBtn = document.getElementById('submit-btn');
            const reviewText = document.getElementById('review_text');
            const charCount = document.getElementById('char-count');
            const courseSelect = document.getElementById('course_id');
            const semesterSelect = document.getElementById('semester');

            const ratingLabels = {
                1: 'Poor',
                2: 'Fair', 
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };

            let selectedRating = 0;

            // Star rating functionality
            starButtons.forEach((btn, index) => {
                btn.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.rating);
                    ratingInput.value = selectedRating;
                    ratingText.textContent = `${selectedRating} Star${selectedRating > 1 ? 's' : ''} - ${ratingLabels[selectedRating]}`;
                    
                    updateStars();
                    checkFormValidity();
                });

                btn.addEventListener('mouseenter', function() {
                    const hoverRating = parseInt(this.dataset.rating);
                    highlightStars(hoverRating);
                });
            });

            document.getElementById('star-rating').addEventListener('mouseleave', function() {
                updateStars();
            });

            function updateStars() {
                starButtons.forEach((btn, index) => {
                    if (index < selectedRating) {
                        btn.classList.remove('text-gray-300');
                        btn.classList.add('text-yellow-400');
                    } else {
                        btn.classList.remove('text-yellow-400');
                        btn.classList.add('text-gray-300');
                    }
                });
            }

            function highlightStars(rating) {
                starButtons.forEach((btn, index) => {
                    if (index < rating) {
                        btn.classList.remove('text-gray-300');
                        btn.classList.add('text-yellow-400');
                    } else {
                        btn.classList.remove('text-yellow-400');
                        btn.classList.add('text-gray-300');
                    }
                });
            }

            // Character count
            if (reviewText && charCount) {
                reviewText.addEventListener('input', function() {
                    const count = this.value.length;
                    charCount.textContent = `${count}/1000`;
                    
                    if (count > 950) {
                        charCount.classList.add('text-red-500');
                    } else {
                        charCount.classList.remove('text-red-500');
                    }
                });
            }

            // Form validation
            function checkFormValidity() {
                const courseSelected = courseSelect.value !== '';
                const semesterSelected = semesterSelect.value !== '';
                const ratingSelected = selectedRating > 0;

                if (courseSelected && semesterSelected && ratingSelected) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }

            // Listen for changes in course and semester
            courseSelect.addEventListener('change', checkFormValidity);
            semesterSelect.addEventListener('change', checkFormValidity);

            // Initial check
            checkFormValidity();

            // Dark mode functionality
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.documentElement.classList.toggle('dark');
                    
                    if (document.documentElement.classList.contains('dark')) {
                        localStorage.setItem('theme', 'dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                    }
                });
            }

            // Apply saved theme
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        });
    </script>
</body>
</html>
