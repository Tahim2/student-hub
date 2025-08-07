<!DOCTYPE html>
<html lang="en" class="dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review - UniHub</title>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Your Review</h1>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ $review->facultyProfile->user->name }} - {{ $review->course->course_name }}
                        </p>
                    </div>
                </div>

                <!-- Review Status -->
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($review->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($review->status === 'flagged') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                        {{ ucfirst($review->status) }}
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Submitted {{ $review->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <form action="{{ route('reviews.update', $review) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Course (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Course
                        </label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300">
                            {{ $review->course->course_code }} - {{ $review->course->course_name }}
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Course cannot be changed after submission</p>
                    </div>

                    <!-- Faculty (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Faculty Member
                        </label>
                        <div class="px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300">
                            {{ $review->facultyProfile->user->name }} - {{ $review->facultyProfile->designation }}
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Faculty member cannot be changed after submission</p>
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
                        <input type="hidden" name="rating" id="rating-input" value="{{ $review->rating }}" required>
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
                            <option value="Fall 2024" {{ $review->semester === 'Fall 2024' ? 'selected' : '' }}>Fall 2024</option>
                            <option value="Spring 2024" {{ $review->semester === 'Spring 2024' ? 'selected' : '' }}>Spring 2024</option>
                            <option value="Summer 2024" {{ $review->semester === 'Summer 2024' ? 'selected' : '' }}>Summer 2024</option>
                            <option value="Fall 2023" {{ $review->semester === 'Fall 2023' ? 'selected' : '' }}>Fall 2023</option>
                            <option value="Spring 2023" {{ $review->semester === 'Spring 2023' ? 'selected' : '' }}>Spring 2023</option>
                            <option value="Summer 2023" {{ $review->semester === 'Summer 2023' ? 'selected' : '' }}>Summer 2023</option>
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
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none">{{ old('review_text', $review->review_text) }}</textarea>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500">Optional - Help other students by sharing your experience</span>
                            <span class="text-xs text-gray-500" id="char-count">{{ strlen($review->review_text ?? '') }}/1000</span>
                        </div>
                        @error('review_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Anonymous Option -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                               {{ $review->is_anonymous ? 'checked' : '' }}
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="is_anonymous" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Submit this review anonymously
                        </label>
                    </div>

                    @if($review->status === 'flagged')
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                        Review Flagged
                                    </h3>
                                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                                        This review has been flagged by moderators. Please review our community guidelines and make appropriate changes.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Buttons -->
                    <div class="flex justify-between pt-4">
                        <div class="flex space-x-4">
                            <a href="{{ route('reviews.my') }}" 
                               class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                                Back to My Reviews
                            </a>
                        </div>
                        
                        <div class="flex space-x-4">
                            <!-- Delete Button -->
                            <button type="button" onclick="confirmDelete()"
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                                Delete Review
                            </button>
                            
                            <!-- Update Button -->
                            <button type="submit" 
                                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                Update Review
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                <form id="delete-form" action="{{ route('reviews.destroy', $review) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-2">Delete Review</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete this review? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-delete" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                    <button id="cancel-delete" 
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starButtons = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('rating-input');
            const ratingText = document.getElementById('rating-text');
            const reviewText = document.getElementById('review_text');
            const charCount = document.getElementById('char-count');

            const ratingLabels = {
                1: 'Poor',
                2: 'Fair', 
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };

            let selectedRating = {{ $review->rating }};

            // Initialize stars and text
            updateStars();
            updateRatingText();

            // Star rating functionality
            starButtons.forEach((btn, index) => {
                btn.addEventListener('click', function() {
                    selectedRating = parseInt(this.dataset.rating);
                    ratingInput.value = selectedRating;
                    updateStars();
                    updateRatingText();
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

            function updateRatingText() {
                ratingText.textContent = `${selectedRating} Star${selectedRating > 1 ? 's' : ''} - ${ratingLabels[selectedRating]}`;
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

        // Delete confirmation functionality
        function confirmDelete() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        document.getElementById('confirm-delete').addEventListener('click', function() {
            document.getElementById('delete-form').submit();
        });

        document.getElementById('cancel-delete').addEventListener('click', function() {
            document.getElementById('delete-modal').classList.add('hidden');
        });

        // Close modal when clicking outside
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
