<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Academic Hub</title>
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
        .form-input {
            padding: 1rem 0.75rem;
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .form-input:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-input::placeholder {
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
        .form-input:focus + label,
        .form-input:not(:placeholder-shown) + label,
        .form-input:valid + label {
            top: -0.5rem;
            left: 0.5rem;
            font-size: 0.75rem;
            color: #3b82f6;
            background-color: #ffffff;
            padding: 0 0.25rem;
        }
        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        select.form-input:focus + label,
        select.form-input:not([value=""]) + label,
        select.form-input[value]:not([value=""]) + label {
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
        .role-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .role-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .role-card.selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .student-id-field {
            animation: slideIn 0.3s ease-in-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .student-fields {
            animation: fadeIn 0.3s ease-in-out;
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
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white transition-colors">Already have an account?</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-md mx-auto">
            <!-- Registration Form -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 animate-fade-in">
                <div class="text-center mb-8">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-blue-600 text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-600">Join the Academic Hub community</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6" onsubmit="return validateForm(event)">
                    @csrf
                    
                    <!-- Display All Validation Errors -->
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center text-red-800 mb-2">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-medium">Please fix the following errors:</span>
                            </div>
                            <ul class="text-red-700 text-sm list-disc ml-6">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Role Selection -->
                    <div class="space-y-3">
                        <label class="text-gray-700 font-medium">Select Your Role</label>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="role-card border-2 border-gray-200 rounded-lg p-4 text-center" onclick="selectRole('student')">
                                <input type="radio" name="role" value="student" class="hidden" {{ old('role') == 'student' ? 'checked' : '' }} required>
                                <i class="fas fa-user-graduate text-blue-500 text-xl mb-2"></i>
                                <div class="text-sm font-medium text-gray-700">Student</div>
                            </div>
                            <div class="role-card border-2 border-gray-200 rounded-lg p-4 text-center" onclick="selectRole('faculty')">
                                <input type="radio" name="role" value="faculty" class="hidden" {{ old('role') == 'faculty' ? 'checked' : '' }} required>
                                <i class="fas fa-chalkboard-teacher text-purple-500 text-xl mb-2"></i>
                                <div class="text-sm font-medium text-gray-700">Faculty</div>
                            </div>
                            <div class="role-card border-2 border-gray-200 rounded-lg p-4 text-center" onclick="selectRole('admin')">
                                <input type="radio" name="role" value="admin" class="hidden" {{ old('role') == 'admin' ? 'checked' : '' }} required>
                                <i class="fas fa-user-shield text-green-500 text-xl mb-2"></i>
                                <div class="text-sm font-medium text-gray-700">Admin</div>
                            </div>
                        </div>
                        @error('role')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Name Input -->
                    <div class="form-floating">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input @error('name') border-red-500 @enderror" 
                               placeholder=" "
                               value="{{ old('name') }}"
                               required>
                        <label for="name">Full Name</label>
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="form-floating">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input @error('email') border-red-500 @enderror" 
                               placeholder=" "
                               value="{{ old('email') }}"
                               required>
                        <label for="email">University Email</label>
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Student ID Input (for students only) -->
                    <div class="form-floating student-id-field" style="display: none;">
                        <input type="text" 
                               id="student_id" 
                               name="student_id" 
                               class="form-input @error('student_id') border-red-500 @enderror" 
                               placeholder=" "
                               value="{{ old('student_id') }}"
                               pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}"
                               title="Student ID format: XXX-XX-XXXX (e.g., 221-15-4750)">
                        <label for="student_id">Student ID</label>
                        <div class="text-xs text-gray-500 mt-1">Format: XXX-XX-XXXX (e.g., 221-15-4750)</div>
                        @error('student_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-floating">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input @error('password') border-red-500 @enderror" 
                               placeholder=" "
                               required>
                        <label for="password">Password</label>
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-floating">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-input @error('password_confirmation') border-red-500 @enderror" 
                               placeholder=" "
                               required>
                        <label for="password_confirmation">Confirm Password</label>
                        @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Student Admission Details -->
                    <div class="student-fields" style="display: none;">
                        <!-- Department Selection for Students -->
                        <div class="form-floating">
                            <select id="department_id_student" 
                                    name="department_id" 
                                    class="form-input @error('department_id') border-red-500 @enderror">
                                <option value="">Select Your Department</option>
                                @if(isset($departments))
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" 
                                                data-semester-type="{{ $department->semester_type }}"
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }} ({{ $department->code }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="department_id_student">Department</label>
                            @error('department_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-floating">
                                <select id="admission_semester" 
                                        name="admission_semester" 
                                        class="form-input @error('admission_semester') border-red-500 @enderror">
                                    <option value="">Select Semester</option>
                                    <option value="Spring" {{ old('admission_semester') == 'Spring' ? 'selected' : '' }}>Spring</option>
                                    <option value="Summer" {{ old('admission_semester') == 'Summer' ? 'selected' : '' }}>Summer</option>
                                    <option value="Fall" {{ old('admission_semester') == 'Fall' ? 'selected' : '' }}>Fall</option>
                                </select>
                                <label for="admission_semester">Admission Semester</label>
                                @error('admission_semester')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <select id="admission_year" 
                                        name="admission_year" 
                                        class="form-input @error('admission_year') border-red-500 @enderror">
                                    <option value="">Select Year</option>
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ old('admission_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                <label for="admission_year">Admission Year</label>
                                @error('admission_year')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Faculty Department Selection -->
                    <div class="faculty-fields" style="display: none;">
                        <div class="form-floating">
                            <select id="department_id_faculty" 
                                    name="department_id" 
                                    class="form-input @error('department_id') border-red-500 @enderror">
                                <option value="">Select Your Department</option>
                                @if(isset($departments))
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" 
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }} ({{ $department->code }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="department_id_faculty">Department</label>
                            @error('department_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               required>
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account & Continue to Login
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

                <!-- Google Registration Button -->
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

                <!-- Info Message -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                    <div class="flex items-center text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span class="text-sm">After creating your account, you'll be redirected to login to access your dashboard.</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Sign in</a>
                    </p>
                </div>

                <!-- Features Preview -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">What you'll get:</h3>
                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Access to faculty reviews and ratings
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Upload and download academic resources
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Personal CGPA tracking system
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectRole(role) {
            console.log('Role selected:', role); // Debug log
            
            // Remove selected class from all cards
            document.querySelectorAll('.role-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
            
            // Check the radio button
            event.currentTarget.querySelector('input[type="radio"]').checked = true;
            
            console.log('Radio button checked:', event.currentTarget.querySelector('input[type="radio"]').checked); // Debug log
            
            // Show/hide fields based on role
            const studentFields = document.querySelector('.student-fields');
            const facultyFields = document.querySelector('.faculty-fields');
            const studentIdField = document.querySelector('.student-id-field');
            
            // Hide all role-specific fields first
            studentFields.style.display = 'none';
            facultyFields.style.display = 'none';
            studentIdField.style.display = 'none';
            
            if (role === 'student') {
                studentFields.style.display = 'block';
                studentIdField.style.display = 'block';
                document.getElementById('admission_semester').required = true;
                document.getElementById('admission_year').required = true;
                document.getElementById('student_id').required = true;
                document.getElementById('department_id_student').required = true;
                document.getElementById('department_id_student').disabled = false;
                document.getElementById('department_id_faculty').required = false;
                document.getElementById('department_id_faculty').disabled = true;
                document.getElementById('department_id_faculty').value = ''; // Clear faculty department
            } else if (role === 'faculty') {
                facultyFields.style.display = 'block';
                document.getElementById('admission_semester').required = false;
                document.getElementById('admission_year').required = false;
                document.getElementById('student_id').required = false;
                document.getElementById('department_id_student').required = false;
                document.getElementById('department_id_student').disabled = true;
                document.getElementById('department_id_student').value = ''; // Clear student department
                document.getElementById('department_id_faculty').required = true;
                document.getElementById('department_id_faculty').disabled = false;
            } else {
                // Admin role
                document.getElementById('admission_semester').required = false;
                document.getElementById('admission_year').required = false;
                document.getElementById('student_id').required = false;
                document.getElementById('department_id_student').required = false;
                document.getElementById('department_id_student').disabled = true;
                document.getElementById('department_id_student').value = '';
                document.getElementById('department_id_faculty').required = false;
                document.getElementById('department_id_faculty').disabled = true;
                document.getElementById('department_id_faculty').value = '';
            }
        }

        // Handle semester options based on department selection
        function updateSemesterOptions() {
            const departmentSelect = document.getElementById('department_id_student');
            const semesterSelect = document.getElementById('admission_semester');
            
            if (!departmentSelect || !semesterSelect) return;
            
            const selectedOption = departmentSelect.options[departmentSelect.selectedIndex];
            const semesterType = selectedOption ? selectedOption.getAttribute('data-semester-type') : null;
            
            // Clear current options except the first one
            semesterSelect.innerHTML = '<option value="">Select Semester</option>';
            
            if (semesterType === 'trisemester') {
                semesterSelect.innerHTML += '<option value="Spring">Spring</option>';
                semesterSelect.innerHTML += '<option value="Summer">Summer</option>';
                semesterSelect.innerHTML += '<option value="Fall">Fall</option>';
            } else if (semesterType === 'bisemester') {
                semesterSelect.innerHTML += '<option value="Spring">Spring</option>';
                semesterSelect.innerHTML += '<option value="Fall">Fall</option>';
            }
            
            // Show info about semester type
            const infoDiv = document.querySelector('.semester-info');
            if (infoDiv) infoDiv.remove();
            
            if (semesterType) {
                const info = document.createElement('div');
                info.className = 'semester-info text-xs text-blue-600 mt-1';
                info.innerHTML = `<i class="fas fa-info-circle mr-1"></i>This department follows ${semesterType === 'trisemester' ? 'tri-semester' : 'bi-semester'} system`;
                semesterSelect.parentNode.appendChild(info);
            }
        }
        
        // Set initial selection if old value exists
        document.addEventListener('DOMContentLoaded', function() {
            // Initially disable both department fields
            document.getElementById('department_id_student').disabled = true;
            document.getElementById('department_id_faculty').disabled = true;
            
            const oldRole = '{{ old("role") }}';
            if (oldRole) {
                document.querySelector(`input[value="${oldRole}"]`).checked = true;
                document.querySelector(`input[value="${oldRole}"]`).closest('.role-card').classList.add('selected');
                selectRole(oldRole);
            }
            
            // Add event listener for department change
            const departmentSelect = document.getElementById('department_id_student');
            if (departmentSelect) {
                departmentSelect.addEventListener('change', updateSemesterOptions);
                // Update on page load if department is pre-selected
                updateSemesterOptions();
            }
        });
        
        // Form validation function
        function validateForm(event) {
            console.log('Form submission started'); // Debug log
            
            // Check if role is selected
            const roleSelected = document.querySelector('input[name="role"]:checked');
            if (!roleSelected) {
                alert('Please select your role (Student, Faculty, or Admin)');
                event.preventDefault();
                return false;
            }
            
            console.log('Role selected:', roleSelected.value); // Debug log
            
            // Check department selection based on role
            if (roleSelected.value === 'student') {
                const studentDept = document.getElementById('department_id_student').value;
                if (!studentDept) {
                    alert('Please select your department');
                    event.preventDefault();
                    return false;
                }
                console.log('Student department selected:', studentDept);
            } else if (roleSelected.value === 'faculty') {
                const facultyDept = document.getElementById('department_id_faculty').value;
                if (!facultyDept) {
                    alert('Please select your department');
                    event.preventDefault();
                    return false;
                }
                console.log('Faculty department selected:', facultyDept);
            }
            
            // Check terms checkbox
            const termsChecked = document.querySelector('#terms').checked;
            if (!termsChecked) {
                alert('Please accept the Terms of Service and Privacy Policy');
                event.preventDefault();
                return false;
            }
            
            console.log('Form validation passed, submitting...'); // Debug log
            return true;
        }
    </script>
    
    <!-- Footer -->
    <footer class="gradient-bg text-white py-6 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2025 Academic Hub. Made by blackSquad. Enhancing university education through technology.</p>
        </div>
    </footer>
</body>
</html>