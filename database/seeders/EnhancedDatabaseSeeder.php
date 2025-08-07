<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Course;
use App\Models\FacultyProfile;
use App\Models\FacultyReview;
use App\Models\Semester;
use Illuminate\Support\Facades\Hash;

class EnhancedDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create additional departments
        $departments = [
            ['name' => 'Computer Science & Engineering', 'code' => 'CSE', 'description' => 'Leading department in computer science and software engineering'],
            ['name' => 'Electrical & Electronic Engineering', 'code' => 'EEE', 'description' => 'Excellence in electrical and electronic engineering'],
            ['name' => 'Business Administration', 'code' => 'BBA', 'description' => 'Comprehensive business and management education'],
            ['name' => 'English Language & Literature', 'code' => 'ELL', 'description' => 'Literature, linguistics, and language studies'],
            ['name' => 'Mathematics', 'code' => 'MATH', 'description' => 'Pure and applied mathematics'],
            ['name' => 'Physics', 'code' => 'PHY', 'description' => 'Fundamental and applied physics research'],
            ['name' => 'Chemistry', 'code' => 'CHEM', 'description' => 'Chemical sciences and research'],
            ['name' => 'Civil Engineering', 'code' => 'CE', 'description' => 'Infrastructure and construction engineering'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }

        // Create comprehensive courses
        $courses = [
            // Computer Science & Engineering
            ['course_code' => 'CSE101', 'course_name' => 'Introduction to Programming', 'description' => 'Basic programming concepts using Python', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE102', 'course_name' => 'Object Oriented Programming', 'description' => 'OOP principles using Java', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE201', 'course_name' => 'Data Structures and Algorithms', 'description' => 'Fundamental data structures and algorithms', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE202', 'course_name' => 'Database Management Systems', 'description' => 'Database design and SQL', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE301', 'course_name' => 'Software Engineering', 'description' => 'Software development methodologies', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE302', 'course_name' => 'Computer Networks', 'description' => 'Network protocols and architecture', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE303', 'course_name' => 'Operating Systems', 'description' => 'OS concepts and system programming', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE401', 'course_name' => 'Machine Learning', 'description' => 'ML algorithms and applications', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE402', 'course_name' => 'Web Development', 'description' => 'Modern web technologies', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE403', 'course_name' => 'Mobile App Development', 'description' => 'iOS and Android development', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],

            // Electrical & Electronic Engineering
            ['course_code' => 'EEE101', 'course_name' => 'Circuit Analysis', 'description' => 'Basic electrical circuits', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'EEE201', 'course_name' => 'Digital Electronics', 'description' => 'Digital logic and circuits', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'EEE301', 'course_name' => 'Power Systems', 'description' => 'Electric power generation and distribution', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'EEE302', 'course_name' => 'Control Systems', 'description' => 'Automatic control theory', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],

            // Business Administration
            ['course_code' => 'BBA101', 'course_name' => 'Principles of Management', 'description' => 'Fundamentals of management', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA201', 'course_name' => 'Marketing Management', 'description' => 'Marketing strategies and analysis', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA301', 'course_name' => 'Financial Management', 'description' => 'Corporate finance and investment', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA401', 'course_name' => 'Strategic Management', 'description' => 'Business strategy and planning', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],

            // English Language & Literature
            ['course_code' => 'ENG101', 'course_name' => 'English Composition', 'description' => 'Academic writing skills', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'ENG201', 'course_name' => 'World Literature', 'description' => 'Literature from around the world', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'ENG301', 'course_name' => 'Shakespeare Studies', 'description' => 'Works of William Shakespeare', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],

            // Mathematics
            ['course_code' => 'MATH101', 'course_name' => 'Calculus I', 'description' => 'Differential and integral calculus', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'MATH201', 'course_name' => 'Linear Algebra', 'description' => 'Vector spaces and matrices', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'MATH301', 'course_name' => 'Differential Equations', 'description' => 'Ordinary differential equations', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],

            // Physics
            ['course_code' => 'PHY101', 'course_name' => 'General Physics I', 'description' => 'Mechanics and thermodynamics', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'PHY201', 'course_name' => 'Quantum Physics', 'description' => 'Introduction to quantum mechanics', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],

            // Chemistry
            ['course_code' => 'CHEM101', 'course_name' => 'General Chemistry', 'description' => 'Basic chemistry principles', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],
            ['course_code' => 'CHEM201', 'course_name' => 'Organic Chemistry', 'description' => 'Organic compounds and reactions', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],

            // Civil Engineering
            ['course_code' => 'CE101', 'course_name' => 'Engineering Mechanics', 'description' => 'Statics and dynamics', 'credits' => 3, 'department_id' => 8, 'level' => 'undergraduate'],
            ['course_code' => 'CE201', 'course_name' => 'Structural Analysis', 'description' => 'Analysis of structures', 'credits' => 3, 'department_id' => 8, 'level' => 'undergraduate'],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['course_code' => $course['course_code']], $course);
        }

        // Create additional faculty users
        $facultyUsers = [
            // CSE Faculty
            ['name' => 'Dr. Sarah Ahmed', 'email' => 'sarah.ahmed@unihub.edu', 'role' => 'faculty'],
            ['name' => 'Prof. Michael Chen', 'email' => 'michael.chen@unihub.edu', 'role' => 'faculty'],
            ['name' => 'Dr. Fatima Khan', 'email' => 'fatima.khan@unihub.edu', 'role' => 'faculty'],
            ['name' => 'Dr. James Wilson', 'email' => 'james.wilson@unihub.edu', 'role' => 'faculty'],
            ['name' => 'Prof. Aisha Rahman', 'email' => 'aisha.rahman@unihub.edu', 'role' => 'faculty'],

            // EEE Faculty
            ['name' => 'Dr. Robert Johnson', 'email' => 'robert.johnson@unihub.edu', 'role' => 'faculty'],
            ['name' => 'Prof. Maria Garcia', 'email' => 'maria.garcia@unihub.edu', 'role' => 'faculty'],

            // BBA Faculty
            ['name' => 'Dr. David Thompson', 'email' => 'david.thompson@unihub.edu', 'role' => 'faculty'],
            ['name' => 'Prof. Lisa Anderson', 'email' => 'lisa.anderson@unihub.edu', 'role' => 'faculty'],

            // English Faculty
            ['name' => 'Dr. Emma Davis', 'email' => 'emma.davis@unihub.edu', 'role' => 'faculty'],

            // Math Faculty
            ['name' => 'Prof. Ahmed Hassan', 'email' => 'ahmed.hassan@unihub.edu', 'role' => 'faculty'],

            // Physics Faculty
            ['name' => 'Dr. Jennifer Lee', 'email' => 'jennifer.lee@unihub.edu', 'role' => 'faculty'],

            // Chemistry Faculty
            ['name' => 'Prof. Carlos Rodriguez', 'email' => 'carlos.rodriguez@unihub.edu', 'role' => 'faculty'],

            // Civil Engineering Faculty
            ['name' => 'Dr. Priya Sharma', 'email' => 'priya.sharma@unihub.edu', 'role' => 'faculty'],
        ];

        foreach ($facultyUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']], 
                array_merge($userData, ['password' => Hash::make('password')])
            );
        }

        // Create faculty profiles
        $facultyProfiles = [
            // CSE Faculty
            ['user_id' => 11, 'employee_id' => 'CSE001', 'designation' => 'Associate Professor', 'department_id' => 1, 'bio' => 'Expert in Machine Learning and Data Science with 8 years of teaching experience.', 'office_location' => 'CSE Building, Room 301', 'phone' => '+880-1700-000001', 'specializations' => ['Machine Learning', 'Data Science', 'Python Programming']],
            ['user_id' => 12, 'employee_id' => 'CSE002', 'designation' => 'Professor', 'department_id' => 1, 'bio' => 'Software Engineering expert with focus on system design and architecture.', 'office_location' => 'CSE Building, Room 305', 'phone' => '+880-1700-000002', 'specializations' => ['Software Engineering', 'System Design', 'Java Programming']],
            ['user_id' => 13, 'employee_id' => 'CSE003', 'designation' => 'Assistant Professor', 'department_id' => 1, 'bio' => 'Database systems and web development specialist.', 'office_location' => 'CSE Building, Room 203', 'phone' => '+880-1700-000003', 'specializations' => ['Database Systems', 'Web Development', 'PHP', 'Laravel']],
            ['user_id' => 14, 'employee_id' => 'CSE004', 'designation' => 'Associate Professor', 'department_id' => 1, 'bio' => 'Computer Networks and Cybersecurity researcher.', 'office_location' => 'CSE Building, Room 307', 'phone' => '+880-1700-000004', 'specializations' => ['Computer Networks', 'Cybersecurity', 'Network Protocols']],
            ['user_id' => 15, 'employee_id' => 'CSE005', 'designation' => 'Professor', 'department_id' => 1, 'bio' => 'Algorithms and Data Structures expert with 12 years of experience.', 'office_location' => 'CSE Building, Room 401', 'phone' => '+880-1700-000005', 'specializations' => ['Algorithms', 'Data Structures', 'Competitive Programming']],

            // EEE Faculty
            ['user_id' => 16, 'employee_id' => 'EEE001', 'designation' => 'Professor', 'department_id' => 2, 'bio' => 'Power systems and renewable energy expert.', 'office_location' => 'EEE Building, Room 201', 'phone' => '+880-1700-000006', 'specializations' => ['Power Systems', 'Renewable Energy', 'Smart Grid']],
            ['user_id' => 17, 'employee_id' => 'EEE002', 'designation' => 'Associate Professor', 'department_id' => 2, 'bio' => 'Digital electronics and embedded systems specialist.', 'office_location' => 'EEE Building, Room 205', 'phone' => '+880-1700-000007', 'specializations' => ['Digital Electronics', 'Embedded Systems', 'Microcontrollers']],

            // BBA Faculty
            ['user_id' => 18, 'employee_id' => 'BBA001', 'designation' => 'Associate Professor', 'department_id' => 3, 'bio' => 'Strategic management and organizational behavior expert.', 'office_location' => 'Business Building, Room 101', 'phone' => '+880-1700-000008', 'specializations' => ['Strategic Management', 'Organizational Behavior', 'Leadership']],
            ['user_id' => 19, 'employee_id' => 'BBA002', 'designation' => 'Professor', 'department_id' => 3, 'bio' => 'Marketing and consumer behavior researcher.', 'office_location' => 'Business Building, Room 105', 'phone' => '+880-1700-000009', 'specializations' => ['Marketing', 'Consumer Behavior', 'Digital Marketing']],

            // English Faculty
            ['user_id' => 20, 'employee_id' => 'ENG001', 'designation' => 'Associate Professor', 'department_id' => 4, 'bio' => 'Victorian literature and creative writing specialist.', 'office_location' => 'Arts Building, Room 301', 'phone' => '+880-1700-000010', 'specializations' => ['Victorian Literature', 'Creative Writing', 'Literary Criticism']],

            // Math Faculty
            ['user_id' => 21, 'employee_id' => 'MATH001', 'designation' => 'Professor', 'department_id' => 5, 'bio' => 'Applied mathematics and mathematical modeling expert.', 'office_location' => 'Science Building, Room 201', 'phone' => '+880-1700-000011', 'specializations' => ['Applied Mathematics', 'Mathematical Modeling', 'Numerical Analysis']],

            // Physics Faculty
            ['user_id' => 22, 'employee_id' => 'PHY001', 'designation' => 'Associate Professor', 'department_id' => 6, 'bio' => 'Quantum physics and materials science researcher.', 'office_location' => 'Science Building, Room 301', 'phone' => '+880-1700-000012', 'specializations' => ['Quantum Physics', 'Materials Science', 'Nanotechnology']],

            // Chemistry Faculty
            ['user_id' => 23, 'employee_id' => 'CHEM001', 'designation' => 'Professor', 'department_id' => 7, 'bio' => 'Organic chemistry and pharmaceutical research specialist.', 'office_location' => 'Science Building, Room 401', 'phone' => '+880-1700-000013', 'specializations' => ['Organic Chemistry', 'Pharmaceutical Chemistry', 'Drug Discovery']],

            // Civil Engineering Faculty
            ['user_id' => 24, 'employee_id' => 'CE001', 'designation' => 'Associate Professor', 'department_id' => 8, 'bio' => 'Structural engineering and earthquake engineering expert.', 'office_location' => 'Engineering Building, Room 201', 'phone' => '+880-1700-000014', 'specializations' => ['Structural Engineering', 'Earthquake Engineering', 'Construction Management']],
        ];

        foreach ($facultyProfiles as $profile) {
            FacultyProfile::firstOrCreate(
                ['user_id' => $profile['user_id']], 
                array_merge($profile, ['is_verified' => true])
            );
        }

        // Create additional student users for reviews
        $studentUsers = [
            ['name' => 'Ali Hassan', 'email' => 'ali.hassan@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Fatima Rahman', 'email' => 'fatima.rahman@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Mohammad Islam', 'email' => 'mohammad.islam@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Samira Khan', 'email' => 'samira.khan@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Rafiq Ahmed', 'email' => 'rafiq.ahmed@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Nadia Sultana', 'email' => 'nadia.sultana@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Karim Uddin', 'email' => 'karim.uddin@student.unihub.edu', 'role' => 'student'],
            ['name' => 'Rashida Begum', 'email' => 'rashida.begum@student.unihub.edu', 'role' => 'student'],
        ];

        foreach ($studentUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']], 
                array_merge($userData, ['password' => Hash::make('password')])
            );
        }

        // Create semesters
        $semesters = [
            ['name' => 'Spring 2023', 'code' => 'S23', 'start_date' => '2023-01-15', 'end_date' => '2023-05-15'],
            ['name' => 'Summer 2023', 'code' => 'U23', 'start_date' => '2023-06-01', 'end_date' => '2023-08-31'],
            ['name' => 'Fall 2023', 'code' => 'F23', 'start_date' => '2023-09-01', 'end_date' => '2023-12-15'],
            ['name' => 'Spring 2024', 'code' => 'S24', 'start_date' => '2024-01-15', 'end_date' => '2024-05-15'],
            ['name' => 'Summer 2024', 'code' => 'U24', 'start_date' => '2024-06-01', 'end_date' => '2024-08-31'],
            ['name' => 'Fall 2024', 'code' => 'F24', 'start_date' => '2024-09-01', 'end_date' => '2024-12-15', 'is_current' => true],
        ];

        foreach ($semesters as $semester) {
            Semester::firstOrCreate(['code' => $semester['code']], $semester);
        }

        // Create comprehensive faculty reviews
        $reviews = [
            // Reviews for Dr. Sarah Ahmed (CSE)
            ['student_id' => 25, 'faculty_id' => 4, 'course_id' => 8, 'rating' => 5, 'review_text' => 'Excellent teacher! Dr. Ahmed explains machine learning concepts very clearly and provides great practical examples.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 26, 'faculty_id' => 4, 'course_id' => 8, 'rating' => 4, 'review_text' => 'Very knowledgeable in ML. Sometimes goes too fast but overall great learning experience.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 27, 'faculty_id' => 4, 'course_id' => 1, 'rating' => 5, 'review_text' => 'Perfect introduction to programming. Dr. Ahmed is patient and encouraging with beginners.', 'semester' => 'Spring 2024', 'is_approved' => true],

            // Reviews for Prof. Michael Chen (CSE)
            ['student_id' => 28, 'faculty_id' => 5, 'course_id' => 5, 'rating' => 4, 'review_text' => 'Software Engineering with Prof. Chen is challenging but rewarding. Learned industry best practices.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 29, 'faculty_id' => 5, 'course_id' => 5, 'rating' => 5, 'review_text' => 'Outstanding! Real-world examples and hands-on projects made the course very practical.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 30, 'faculty_id' => 5, 'course_id' => 2, 'rating' => 4, 'review_text' => 'Good OOP concepts explained. Prof. Chen uses Java very effectively in teaching.', 'semester' => 'Summer 2024', 'is_approved' => true],

            // Reviews for Dr. Fatima Khan (CSE)
            ['student_id' => 25, 'faculty_id' => 6, 'course_id' => 4, 'rating' => 5, 'review_text' => 'Database course was amazing! Dr. Khan makes complex SQL queries look easy.', 'semester' => 'Spring 2024', 'is_approved' => true],
            ['student_id' => 31, 'faculty_id' => 6, 'course_id' => 9, 'rating' => 4, 'review_text' => 'Web development course covered modern frameworks. Laravel section was particularly helpful.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 32, 'faculty_id' => 6, 'course_id' => 4, 'rating' => 5, 'review_text' => 'Best database teacher! Clear explanations and practical assignments.', 'semester' => 'Summer 2024', 'is_approved' => true],

            // Reviews for Dr. James Wilson (CSE)
            ['student_id' => 26, 'faculty_id' => 7, 'course_id' => 6, 'rating' => 4, 'review_text' => 'Computer Networks was well structured. Dr. Wilson knows his subject very well.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 27, 'faculty_id' => 7, 'course_id' => 7, 'rating' => 4, 'review_text' => 'Operating Systems concepts were explained clearly. Good use of Linux examples.', 'semester' => 'Spring 2024', 'is_approved' => true],

            // Reviews for Prof. Aisha Rahman (CSE)
            ['student_id' => 28, 'faculty_id' => 8, 'course_id' => 3, 'rating' => 5, 'review_text' => 'Data Structures and Algorithms made easy! Prof. Rahman is an excellent teacher.', 'semester' => 'Spring 2024', 'is_approved' => true],
            ['student_id' => 29, 'faculty_id' => 8, 'course_id' => 3, 'rating' => 5, 'review_text' => 'Best algorithms teacher. Competitive programming tips were very helpful.', 'semester' => 'Spring 2024', 'is_approved' => true],

            // Reviews for Dr. Robert Johnson (EEE)
            ['student_id' => 30, 'faculty_id' => 9, 'course_id' => 13, 'rating' => 4, 'review_text' => 'Power Systems course was comprehensive. Dr. Johnson has great industry experience.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 31, 'faculty_id' => 9, 'course_id' => 11, 'rating' => 4, 'review_text' => 'Circuit Analysis fundamentals were well covered. Good lab sessions.', 'semester' => 'Spring 2024', 'is_approved' => true],

            // Reviews for Prof. Maria Garcia (EEE)
            ['student_id' => 32, 'faculty_id' => 10, 'course_id' => 12, 'rating' => 5, 'review_text' => 'Digital Electronics with Prof. Garcia was fantastic. Hands-on approach to learning.', 'semester' => 'Fall 2024', 'is_approved' => true],

            // Reviews for Dr. David Thompson (BBA)
            ['student_id' => 25, 'faculty_id' => 11, 'course_id' => 18, 'rating' => 4, 'review_text' => 'Strategic Management concepts were well explained. Good case study discussions.', 'semester' => 'Fall 2024', 'is_approved' => true],
            ['student_id' => 26, 'faculty_id' => 11, 'course_id' => 15, 'rating' => 4, 'review_text' => 'Management principles taught with real examples. Dr. Thompson is very approachable.', 'semester' => 'Spring 2024', 'is_approved' => true],

            // Reviews for Prof. Lisa Anderson (BBA)
            ['student_id' => 27, 'faculty_id' => 12, 'course_id' => 16, 'rating' => 5, 'review_text' => 'Marketing course was excellent! Prof. Anderson brings practical marketing experience.', 'semester' => 'Fall 2024', 'is_approved' => true],

            // Reviews for Dr. Emma Davis (English)
            ['student_id' => 28, 'faculty_id' => 13, 'course_id' => 19, 'rating' => 5, 'review_text' => 'English Composition improved my writing significantly. Dr. Davis provides great feedback.', 'semester' => 'Spring 2024', 'is_approved' => true],
            ['student_id' => 29, 'faculty_id' => 13, 'course_id' => 21, 'rating' => 4, 'review_text' => 'Shakespeare Studies was challenging but rewarding. Loved the interactive discussions.', 'semester' => 'Fall 2024', 'is_approved' => true],

            // Reviews for Prof. Ahmed Hassan (Math)
            ['student_id' => 30, 'faculty_id' => 14, 'course_id' => 22, 'rating' => 4, 'review_text' => 'Calculus I was well taught. Prof. Hassan explains complex concepts step by step.', 'semester' => 'Spring 2024', 'is_approved' => true],
            ['student_id' => 31, 'faculty_id' => 14, 'course_id' => 23, 'rating' => 4, 'review_text' => 'Linear Algebra concepts were clear. Good problem-solving approach.', 'semester' => 'Fall 2024', 'is_approved' => true],
        ];

        foreach ($reviews as $review) {
            FacultyReview::firstOrCreate([
                'student_id' => $review['student_id'],
                'faculty_id' => $review['faculty_id'],
                'course_id' => $review['course_id']
            ], $review);
        }

        // Update faculty ratings
        $facultyProfiles = FacultyProfile::all();
        foreach ($facultyProfiles as $faculty) {
            $faculty->updateRating();
        }

        // Create sample resources
        $resources = [
            // CSE Resources
            ['title' => 'Introduction to Python Programming', 'description' => 'Complete Python programming guide for beginners', 'course_id' => 1, 'uploaded_by' => 4, 'type' => 'link', 'external_url' => 'https://docs.python.org/3/tutorial/', 'tags' => ['python', 'programming', 'tutorial'], 'is_approved' => true, 'download_count' => 45],
            ['title' => 'Data Structures Lecture Notes', 'description' => 'Comprehensive notes on arrays, linked lists, stacks, and queues', 'course_id' => 3, 'uploaded_by' => 8, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 2048576, 'tags' => ['data-structures', 'algorithms', 'notes'], 'is_approved' => true, 'download_count' => 89],
            ['title' => 'Database Design Assignment', 'description' => 'Practice assignment on ER diagrams and normalization', 'course_id' => 4, 'uploaded_by' => 6, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 1024000, 'tags' => ['database', 'assignment', 'er-diagram'], 'is_approved' => true, 'download_count' => 67],
            ['title' => 'Machine Learning Algorithms Guide', 'description' => 'Detailed explanation of ML algorithms with examples', 'course_id' => 8, 'uploaded_by' => 4, 'type' => 'link', 'external_url' => 'https://scikit-learn.org/stable/user_guide.html', 'tags' => ['machine-learning', 'algorithms', 'guide'], 'is_approved' => true, 'download_count' => 123],
            ['title' => 'Web Development Lab Manual', 'description' => 'Step-by-step lab exercises for web development', 'course_id' => 9, 'uploaded_by' => 6, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 5120000, 'tags' => ['web-development', 'lab', 'html', 'css'], 'is_approved' => true, 'download_count' => 78],
            ['title' => 'OOP in Java Tutorial', 'description' => 'Object-oriented programming concepts with Java examples', 'course_id' => 2, 'uploaded_by' => 5, 'type' => 'link', 'external_url' => 'https://docs.oracle.com/javase/tutorial/java/concepts/', 'tags' => ['java', 'oop', 'tutorial'], 'is_approved' => true, 'download_count' => 91],
            ['title' => 'Software Engineering Best Practices', 'description' => 'Industry best practices for software development', 'course_id' => 5, 'uploaded_by' => 5, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 3072000, 'tags' => ['software-engineering', 'best-practices'], 'is_approved' => true, 'download_count' => 56],
            ['title' => 'Computer Networks Lab Exercises', 'description' => 'Hands-on exercises for network configuration', 'course_id' => 6, 'uploaded_by' => 7, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 4096000, 'tags' => ['networking', 'lab', 'cisco'], 'is_approved' => true, 'download_count' => 43],

            // EEE Resources
            ['title' => 'Circuit Analysis Fundamentals', 'description' => 'Basic concepts of electrical circuit analysis', 'course_id' => 11, 'uploaded_by' => 9, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 2560000, 'tags' => ['circuits', 'analysis', 'electrical'], 'is_approved' => true, 'download_count' => 65],
            ['title' => 'Digital Electronics Lab Manual', 'description' => 'Laboratory experiments for digital circuits', 'course_id' => 12, 'uploaded_by' => 10, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 3584000, 'tags' => ['digital', 'electronics', 'lab'], 'is_approved' => true, 'download_count' => 52],
            ['title' => 'Power Systems Analysis', 'description' => 'Comprehensive guide to power system analysis', 'course_id' => 13, 'uploaded_by' => 9, 'type' => 'link', 'external_url' => 'https://www.electrical-engineering-portal.com/power-systems', 'tags' => ['power-systems', 'analysis'], 'is_approved' => true, 'download_count' => 38],

            // BBA Resources
            ['title' => 'Management Principles Textbook', 'description' => 'Comprehensive textbook on management principles', 'course_id' => 15, 'uploaded_by' => 11, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 8192000, 'tags' => ['management', 'textbook', 'principles'], 'is_approved' => true, 'download_count' => 87],
            ['title' => 'Marketing Strategy Case Studies', 'description' => 'Real-world case studies in marketing', 'course_id' => 16, 'uploaded_by' => 12, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 6144000, 'tags' => ['marketing', 'case-studies', 'strategy'], 'is_approved' => true, 'download_count' => 74],
            ['title' => 'Financial Management Formulas', 'description' => 'Important formulas for financial calculations', 'course_id' => 17, 'uploaded_by' => 11, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 1536000, 'tags' => ['finance', 'formulas', 'calculations'], 'is_approved' => true, 'download_count' => 95],

            // Math Resources
            ['title' => 'Calculus I Problem Sets', 'description' => 'Practice problems for calculus fundamentals', 'course_id' => 22, 'uploaded_by' => 14, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 2048000, 'tags' => ['calculus', 'problems', 'math'], 'is_approved' => true, 'download_count' => 76],
            ['title' => 'Linear Algebra Solutions Manual', 'description' => 'Step-by-step solutions to linear algebra problems', 'course_id' => 23, 'uploaded_by' => 14, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 4608000, 'tags' => ['linear-algebra', 'solutions', 'manual'], 'is_approved' => true, 'download_count' => 68],

            // Physics Resources
            ['title' => 'General Physics Lab Experiments', 'description' => 'Laboratory experiments for general physics', 'course_id' => 25, 'uploaded_by' => 15, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 5632000, 'tags' => ['physics', 'lab', 'experiments'], 'is_approved' => true, 'download_count' => 54],
            ['title' => 'Quantum Physics Lecture Notes', 'description' => 'Comprehensive notes on quantum mechanics', 'course_id' => 26, 'uploaded_by' => 15, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 7168000, 'tags' => ['quantum', 'physics', 'notes'], 'is_approved' => true, 'download_count' => 41],

            // Chemistry Resources
            ['title' => 'Organic Chemistry Reaction Mechanisms', 'description' => 'Detailed mechanisms for organic reactions', 'course_id' => 28, 'uploaded_by' => 16, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 3584000, 'tags' => ['organic', 'chemistry', 'mechanisms'], 'is_approved' => true, 'download_count' => 63],
            ['title' => 'General Chemistry Lab Manual', 'description' => 'Laboratory procedures for general chemistry', 'course_id' => 27, 'uploaded_by' => 16, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 4096000, 'tags' => ['chemistry', 'lab', 'manual'], 'is_approved' => true, 'download_count' => 59],
        ];

        foreach ($resources as $resource) {
            \App\Models\Resource::firstOrCreate(['title' => $resource['title']], $resource);
        }

        echo "Enhanced database seeding completed!\n";
        echo "Added:\n";
        echo "- " . count($departments) . " departments\n";
        echo "- " . count($courses) . " courses\n";
        echo "- " . count($facultyUsers) . " faculty members\n";
        echo "- " . count($studentUsers) . " additional students\n";
        echo "- " . count($reviews) . " faculty reviews\n";
        echo "- " . count($resources) . " resources\n";
    }
}
