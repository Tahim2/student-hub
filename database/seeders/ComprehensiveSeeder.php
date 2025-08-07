<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Course;
use App\Models\FacultyProfile;
use App\Models\FacultyReview;
use App\Models\Semester;
use App\Models\StudentGrade;
use App\Models\Resource;
use Illuminate\Support\Facades\Hash;

class ComprehensiveSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        StudentGrade::truncate();
        FacultyReview::truncate();
        Resource::truncate();
        FacultyProfile::truncate();
        Course::truncate();
        Department::truncate();
        Semester::truncate();
        User::where('id', '>', 1)->delete(); // Keep the first admin user

        // Create departments (removing Chemistry, Physics, English Language & Literature)
        $departments = [
            ['name' => 'Computer Science & Engineering', 'code' => 'CSE', 'description' => 'Leading department in computer science and software engineering'],
            ['name' => 'Software Engineering', 'code' => 'SWE', 'description' => 'Software development and engineering practices'],
            ['name' => 'Business Administration', 'code' => 'BBA', 'description' => 'Comprehensive business and management education'],
            ['name' => 'Electrical & Electronic Engineering', 'code' => 'EEE', 'description' => 'Excellence in electrical and electronic engineering'],
            ['name' => 'Civil Engineering', 'code' => 'CE', 'description' => 'Infrastructure and construction engineering'],
            ['name' => 'Textile Engineering', 'code' => 'TE', 'description' => 'Textile manufacturing and engineering'],
            ['name' => 'English', 'code' => 'ENG', 'description' => 'English language and communication skills'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Create semesters based on department requirements
        $semesters = [];
        
        // 12 semesters for CSE, SWE, BBA, English
        for ($i = 1; $i <= 12; $i++) {
            $year = ceil($i / 2);
            $term = ($i % 2 === 1) ? 'Spring' : 'Fall';
            $semesters[] = [
                'name' => "Semester $i ($term Year $year)",
                'code' => "S$i",
                'start_date' => "2024-" . sprintf('%02d', $i) . "-01",
                'end_date' => "2024-" . sprintf('%02d', $i) . "-30",
                'is_current' => $i === 8,
                'is_active' => true
            ];
        }

        // 8 semesters for EEE, Civil, Textile
        for ($i = 1; $i <= 8; $i++) {
            $year = ceil($i / 2);
            $term = ($i % 2 === 1) ? 'Spring' : 'Fall';
            $semesters[] = [
                'name' => "EEE/CE/TE Semester $i ($term Year $year)",
                'code' => "E$i",
                'start_date' => "2024-" . sprintf('%02d', $i + 12) . "-01",
                'end_date' => "2024-" . sprintf('%02d', $i + 12) . "-30",
                'is_current' => $i === 6,
                'is_active' => true
            ];
        }

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }

        // Create comprehensive courses
        $courses = [
            // CSE Courses (12 semesters)
            // Semester 1
            ['course_code' => 'CSE111', 'course_name' => 'Computer Fundamentals', 'description' => 'Basic computer concepts', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE112', 'course_name' => 'Programming Fundamentals', 'description' => 'Introduction to programming', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'MAT111', 'course_name' => 'Mathematics I', 'description' => 'Calculus and algebra', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'ENG111', 'course_name' => 'English I', 'description' => 'Basic English communication', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            
            // Semester 2
            ['course_code' => 'CSE121', 'course_name' => 'Object Oriented Programming', 'description' => 'OOP concepts with Java', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE122', 'course_name' => 'Discrete Mathematics', 'description' => 'Mathematical foundations', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'MAT121', 'course_name' => 'Mathematics II', 'description' => 'Advanced calculus', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'ENG121', 'course_name' => 'English II', 'description' => 'Technical writing', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            
            // Semester 3
            ['course_code' => 'CSE231', 'course_name' => 'Data Structures', 'description' => 'Data structures and algorithms', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE232', 'course_name' => 'Digital Logic Design', 'description' => 'Digital circuits and logic', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'MAT231', 'course_name' => 'Linear Algebra', 'description' => 'Vectors and matrices', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'PHY231', 'course_name' => 'Physics I', 'description' => 'Mechanics and heat', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            
            // Continue with more CSE courses...
            ['course_code' => 'CSE341', 'course_name' => 'Database Systems', 'description' => 'Database design and management', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE342', 'course_name' => 'Algorithm Analysis', 'description' => 'Algorithm design and analysis', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE451', 'course_name' => 'Software Engineering', 'description' => 'Software development methodologies', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE452', 'course_name' => 'Computer Networks', 'description' => 'Network protocols and security', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE461', 'course_name' => 'Machine Learning', 'description' => 'ML algorithms and applications', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],
            ['course_code' => 'CSE462', 'course_name' => 'Web Technologies', 'description' => 'Web development frameworks', 'credits' => 3, 'department_id' => 1, 'level' => 'undergraduate'],

            // SWE Courses (12 semesters)
            ['course_code' => 'SWE111', 'course_name' => 'Introduction to Software Engineering', 'description' => 'Software engineering basics', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE112', 'course_name' => 'Programming Fundamentals', 'description' => 'Basic programming concepts', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE221', 'course_name' => 'Software Design Patterns', 'description' => 'Design patterns in software', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE222', 'course_name' => 'Software Testing', 'description' => 'Testing methodologies', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE331', 'course_name' => 'Software Architecture', 'description' => 'System architecture design', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE332', 'course_name' => 'Agile Development', 'description' => 'Agile methodologies', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE441', 'course_name' => 'DevOps Practices', 'description' => 'Development and operations', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],
            ['course_code' => 'SWE442', 'course_name' => 'Mobile App Development', 'description' => 'Mobile application development', 'credits' => 3, 'department_id' => 2, 'level' => 'undergraduate'],

            // BBA Courses (12 semesters)
            ['course_code' => 'BBA111', 'course_name' => 'Principles of Management', 'description' => 'Management fundamentals', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA112', 'course_name' => 'Introduction to Business', 'description' => 'Business environment', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA221', 'course_name' => 'Marketing Management', 'description' => 'Marketing principles', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA222', 'course_name' => 'Financial Accounting', 'description' => 'Accounting principles', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA331', 'course_name' => 'Human Resource Management', 'description' => 'HR practices', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA332', 'course_name' => 'Operations Management', 'description' => 'Operations and supply chain', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA441', 'course_name' => 'Strategic Management', 'description' => 'Business strategy', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],
            ['course_code' => 'BBA442', 'course_name' => 'International Business', 'description' => 'Global business practices', 'credits' => 3, 'department_id' => 3, 'level' => 'undergraduate'],

            // English Courses (12 semesters)
            ['course_code' => 'ENG111', 'course_name' => 'English Composition', 'description' => 'Basic writing skills', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],
            ['course_code' => 'ENG112', 'course_name' => 'Literature Survey', 'description' => 'Introduction to literature', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],
            ['course_code' => 'ENG221', 'course_name' => 'Advanced Grammar', 'description' => 'English grammar rules', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],
            ['course_code' => 'ENG222', 'course_name' => 'Creative Writing', 'description' => 'Creative writing techniques', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],
            ['course_code' => 'ENG331', 'course_name' => 'Linguistics', 'description' => 'Language structure and use', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],
            ['course_code' => 'ENG332', 'course_name' => 'World Literature', 'description' => 'Global literary works', 'credits' => 3, 'department_id' => 7, 'level' => 'undergraduate'],

            // EEE Courses (8 semesters)
            ['course_code' => 'EEE111', 'course_name' => 'Electrical Circuits', 'description' => 'Basic electrical circuits', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE112', 'course_name' => 'Electronics I', 'description' => 'Electronic devices', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE221', 'course_name' => 'Digital Electronics', 'description' => 'Digital logic circuits', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE222', 'course_name' => 'Electronics II', 'description' => 'Advanced electronics', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE331', 'course_name' => 'Power Systems', 'description' => 'Electrical power systems', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE332', 'course_name' => 'Control Systems', 'description' => 'Automatic control', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE441', 'course_name' => 'Communication Systems', 'description' => 'Communication engineering', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],
            ['course_code' => 'EEE442', 'course_name' => 'Renewable Energy', 'description' => 'Sustainable energy systems', 'credits' => 3, 'department_id' => 4, 'level' => 'undergraduate'],

            // Civil Engineering Courses (8 semesters)
            ['course_code' => 'CE111', 'course_name' => 'Engineering Mechanics', 'description' => 'Statics and dynamics', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE112', 'course_name' => 'Engineering Drawing', 'description' => 'Technical drawing', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE221', 'course_name' => 'Strength of Materials', 'description' => 'Material properties', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE222', 'course_name' => 'Surveying', 'description' => 'Land surveying techniques', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE331', 'course_name' => 'Structural Analysis', 'description' => 'Analysis of structures', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE332', 'course_name' => 'Concrete Technology', 'description' => 'Concrete materials', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE441', 'course_name' => 'Foundation Engineering', 'description' => 'Foundation design', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],
            ['course_code' => 'CE442', 'course_name' => 'Construction Management', 'description' => 'Project management', 'credits' => 3, 'department_id' => 5, 'level' => 'undergraduate'],

            // Textile Engineering Courses (8 semesters)
            ['course_code' => 'TE111', 'course_name' => 'Textile Fibers', 'description' => 'Fiber properties and types', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE112', 'course_name' => 'Yarn Manufacturing', 'description' => 'Yarn production processes', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE221', 'course_name' => 'Fabric Manufacturing', 'description' => 'Weaving and knitting', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE222', 'course_name' => 'Textile Chemistry', 'description' => 'Chemical processes in textiles', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE331', 'course_name' => 'Dyeing and Finishing', 'description' => 'Textile finishing processes', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE332', 'course_name' => 'Textile Testing', 'description' => 'Quality control in textiles', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE441', 'course_name' => 'Apparel Manufacturing', 'description' => 'Garment production', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
            ['course_code' => 'TE442', 'course_name' => 'Textile Management', 'description' => 'Textile business management', 'credits' => 3, 'department_id' => 6, 'level' => 'undergraduate'],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }

        // Create users with proper email formats
        $users = [
            // Admin users
            ['name' => 'System Administrator', 'email' => 'admin@diu.edu.bd', 'role' => 'admin'],
            ['name' => 'Academic Administrator', 'email' => 'academic.admin@diu.edu.bd', 'role' => 'admin'],
            
            // Faculty users
            ['name' => 'Dr. Sarah Ahmed', 'email' => 'sarah.cse@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Prof. Michael Chen', 'email' => 'michael.cse@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Dr. Fatima Khan', 'email' => 'fatima.swe@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Dr. James Wilson', 'email' => 'james.swe@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Prof. Aisha Rahman', 'email' => 'aisha.cse@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Dr. Robert Johnson', 'email' => 'robert.eee@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Prof. Maria Garcia', 'email' => 'maria.eee@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Dr. David Thompson', 'email' => 'david.bba@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Prof. Lisa Anderson', 'email' => 'lisa.bba@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Dr. Emma Davis', 'email' => 'emma.eng@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Prof. Ahmed Hassan', 'email' => 'ahmed.ce@diu.edu.bd', 'role' => 'faculty'],
            ['name' => 'Dr. Jennifer Lee', 'email' => 'jennifer.te@diu.edu.bd', 'role' => 'faculty'],
            
            // Student users
            ['name' => 'Ali Hassan', 'email' => 'ali.hassan@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Fatima Rahman', 'email' => 'fatima.rahman@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Mohammad Islam', 'email' => 'mohammad.islam@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Samira Khan', 'email' => 'samira.khan@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Rafiq Ahmed', 'email' => 'rafiq.ahmed@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Nadia Sultana', 'email' => 'nadia.sultana@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Karim Uddin', 'email' => 'karim.uddin@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Rashida Begum', 'email' => 'rashida.begum@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Tanvir Hasan', 'email' => 'tanvir.hasan@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Sabrina Akter', 'email' => 'sabrina.akter@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Riaz Uddin', 'email' => 'riaz.uddin@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Munira Khatun', 'email' => 'munira.khatun@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Nasir Ahmed', 'email' => 'nasir.ahmed@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Salma Begum', 'email' => 'salma.begum@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Hasan Ali', 'email' => 'hasan.ali@diu.edu.bd', 'role' => 'student'],
            ['name' => 'Tahmina Khatun', 'email' => 'tahmina.khatun@diu.edu.bd', 'role' => 'student'],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, ['password' => Hash::make('password')]));
        }

        // Create faculty profiles
        $facultyProfiles = [
            ['user_id' => 3, 'employee_id' => 'CSE001', 'designation' => 'Associate Professor', 'department_id' => 1, 'bio' => 'Expert in Machine Learning and Data Science', 'office_location' => 'CSE Building, Room 301', 'phone' => '+880-1700-000001', 'specializations' => ['Machine Learning', 'Data Science', 'Python'], 'is_verified' => true],
            ['user_id' => 4, 'employee_id' => 'CSE002', 'designation' => 'Professor', 'department_id' => 1, 'bio' => 'Software Engineering expert', 'office_location' => 'CSE Building, Room 305', 'phone' => '+880-1700-000002', 'specializations' => ['Software Engineering', 'System Design', 'Java'], 'is_verified' => true],
            ['user_id' => 5, 'employee_id' => 'SWE001', 'designation' => 'Assistant Professor', 'department_id' => 2, 'bio' => 'Software development specialist', 'office_location' => 'SWE Building, Room 203', 'phone' => '+880-1700-000003', 'specializations' => ['Web Development', 'PHP', 'Laravel'], 'is_verified' => true],
            ['user_id' => 6, 'employee_id' => 'SWE002', 'designation' => 'Associate Professor', 'department_id' => 2, 'bio' => 'Software testing and quality assurance', 'office_location' => 'SWE Building, Room 207', 'phone' => '+880-1700-000004', 'specializations' => ['Software Testing', 'Quality Assurance'], 'is_verified' => true],
            ['user_id' => 7, 'employee_id' => 'CSE003', 'designation' => 'Professor', 'department_id' => 1, 'bio' => 'Algorithms and Data Structures expert', 'office_location' => 'CSE Building, Room 401', 'phone' => '+880-1700-000005', 'specializations' => ['Algorithms', 'Data Structures'], 'is_verified' => true],
            ['user_id' => 8, 'employee_id' => 'EEE001', 'designation' => 'Professor', 'department_id' => 4, 'bio' => 'Power systems expert', 'office_location' => 'EEE Building, Room 201', 'phone' => '+880-1700-000006', 'specializations' => ['Power Systems', 'Renewable Energy'], 'is_verified' => true],
            ['user_id' => 9, 'employee_id' => 'EEE002', 'designation' => 'Associate Professor', 'department_id' => 4, 'bio' => 'Electronics specialist', 'office_location' => 'EEE Building, Room 205', 'phone' => '+880-1700-000007', 'specializations' => ['Electronics', 'Embedded Systems'], 'is_verified' => true],
            ['user_id' => 10, 'employee_id' => 'BBA001', 'designation' => 'Associate Professor', 'department_id' => 3, 'bio' => 'Management expert', 'office_location' => 'Business Building, Room 101', 'phone' => '+880-1700-000008', 'specializations' => ['Management', 'Strategy'], 'is_verified' => true],
            ['user_id' => 11, 'employee_id' => 'BBA002', 'designation' => 'Professor', 'department_id' => 3, 'bio' => 'Marketing specialist', 'office_location' => 'Business Building, Room 105', 'phone' => '+880-1700-000009', 'specializations' => ['Marketing', 'Consumer Behavior'], 'is_verified' => true],
            ['user_id' => 12, 'employee_id' => 'ENG001', 'designation' => 'Associate Professor', 'department_id' => 7, 'bio' => 'English language expert', 'office_location' => 'Arts Building, Room 301', 'phone' => '+880-1700-000010', 'specializations' => ['English Language', 'Literature'], 'is_verified' => true],
            ['user_id' => 13, 'employee_id' => 'CE001', 'designation' => 'Professor', 'department_id' => 5, 'bio' => 'Structural engineering expert', 'office_location' => 'Engineering Building, Room 201', 'phone' => '+880-1700-000011', 'specializations' => ['Structural Engineering', 'Construction'], 'is_verified' => true],
            ['user_id' => 14, 'employee_id' => 'TE001', 'designation' => 'Associate Professor', 'department_id' => 6, 'bio' => 'Textile engineering specialist', 'office_location' => 'Textile Building, Room 101', 'phone' => '+880-1700-000012', 'specializations' => ['Textile Engineering', 'Apparel'], 'is_verified' => true],
        ];

        foreach ($facultyProfiles as $profile) {
            FacultyProfile::create($profile);
        }

        // Create sample student grades
        $studentGrades = [];
        $students = User::where('role', 'student')->get();
        $courses = Course::all();
        $semesters = Semester::all();
        $grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D'];

        foreach ($students as $student) {
            // Generate grades for multiple semesters
            for ($semesterIndex = 0; $semesterIndex < 4; $semesterIndex++) {
                $semester = $semesters[$semesterIndex];
                $coursesForSemester = $courses->random(rand(4, 6));
                
                foreach ($coursesForSemester as $course) {
                    $grade = $grades[array_rand($grades)];
                    $gradePoint = $this->getGradePoint($grade);
                    
                    $studentGrades[] = [
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'semester_id' => $semester->id,
                        'grade' => $grade,
                        'credit_hours' => $course->credits,
                        'grade_points' => $course->credits * $gradePoint,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        StudentGrade::insert($studentGrades);

        // Create faculty reviews
        $reviews = [];
        $reviewTexts = [
            'Excellent teacher! Very knowledgeable and helpful.',
            'Good teaching style and clear explanations.',
            'Very supportive and encouraging.',
            'Great professor with practical examples.',
            'Challenging but fair in assessment.',
            'Engaging lectures and good course content.',
            'Helpful during office hours.',
            'Well-structured course material.',
            'Inspiring and motivating instructor.',
            'Professional and experienced faculty.'
        ];

        foreach ($students->take(10) as $student) {
            $facultyMembers = FacultyProfile::inRandomOrder()->take(3)->get();
            
            foreach ($facultyMembers as $faculty) {
                $coursesForFaculty = $courses->where('department_id', $faculty->department_id)->random(1);
                
                foreach ($coursesForFaculty as $course) {
                    $reviews[] = [
                        'student_id' => $student->id,
                        'faculty_id' => $faculty->id,
                        'course_id' => $course->id,
                        'rating' => rand(3, 5),
                        'review_text' => $reviewTexts[array_rand($reviewTexts)],
                        'semester' => 'Fall 2024',
                        'is_approved' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        FacultyReview::insert($reviews);

        // Create comprehensive resources
        $resources = [
            // CSE Resources
            ['title' => 'CSE111 - Computer Fundamentals Notes', 'description' => 'Complete notes for computer fundamentals', 'course_id' => 1, 'uploaded_by' => 3, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 2048576, 'tags' => ['fundamentals', 'computer', 'notes'], 'is_approved' => true, 'download_count' => 45],
            ['title' => 'Programming Fundamentals Lab Manual', 'description' => 'Lab exercises for programming basics', 'course_id' => 2, 'uploaded_by' => 4, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 3072000, 'tags' => ['programming', 'lab', 'manual'], 'is_approved' => true, 'download_count' => 67],
            ['title' => 'Data Structures Implementation Guide', 'description' => 'Implementation examples for data structures', 'course_id' => 9, 'uploaded_by' => 7, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 4096000, 'tags' => ['data-structures', 'implementation'], 'is_approved' => true, 'download_count' => 89],
            
            // SWE Resources
            ['title' => 'Software Engineering Best Practices', 'description' => 'Industry best practices for software development', 'course_id' => 21, 'uploaded_by' => 5, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 5120000, 'tags' => ['software-engineering', 'best-practices'], 'is_approved' => true, 'download_count' => 78],
            ['title' => 'Design Patterns Examples', 'description' => 'Common design patterns with examples', 'course_id' => 23, 'uploaded_by' => 6, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 3584000, 'tags' => ['design-patterns', 'examples'], 'is_approved' => true, 'download_count' => 56],
            
            // BBA Resources
            ['title' => 'Management Principles Handbook', 'description' => 'Comprehensive management principles guide', 'course_id' => 29, 'uploaded_by' => 10, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 6144000, 'tags' => ['management', 'principles'], 'is_approved' => true, 'download_count' => 92],
            ['title' => 'Marketing Strategy Case Studies', 'description' => 'Real-world marketing case studies', 'course_id' => 31, 'uploaded_by' => 11, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 7168000, 'tags' => ['marketing', 'case-studies'], 'is_approved' => true, 'download_count' => 74],
            
            // EEE Resources
            ['title' => 'Electrical Circuits Analysis', 'description' => 'Circuit analysis techniques and examples', 'course_id' => 41, 'uploaded_by' => 8, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 4608000, 'tags' => ['circuits', 'analysis'], 'is_approved' => true, 'download_count' => 63],
            ['title' => 'Power Systems Study Guide', 'description' => 'Comprehensive power systems guide', 'course_id' => 45, 'uploaded_by' => 8, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 8192000, 'tags' => ['power-systems', 'guide'], 'is_approved' => true, 'download_count' => 85],
            
            // Civil Engineering Resources
            ['title' => 'Engineering Mechanics Solutions', 'description' => 'Solved problems in engineering mechanics', 'course_id' => 49, 'uploaded_by' => 13, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 5632000, 'tags' => ['mechanics', 'solutions'], 'is_approved' => true, 'download_count' => 71],
            ['title' => 'Structural Analysis Manual', 'description' => 'Structural analysis methods and examples', 'course_id' => 53, 'uploaded_by' => 13, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 9216000, 'tags' => ['structural', 'analysis'], 'is_approved' => true, 'download_count' => 68],
            
            // Textile Engineering Resources
            ['title' => 'Textile Fibers Handbook', 'description' => 'Complete guide to textile fibers', 'course_id' => 57, 'uploaded_by' => 14, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 6656000, 'tags' => ['textile', 'fibers'], 'is_approved' => true, 'download_count' => 54],
            ['title' => 'Apparel Manufacturing Guide', 'description' => 'Garment production processes', 'course_id' => 63, 'uploaded_by' => 14, 'type' => 'file', 'file_type' => 'pdf', 'file_size' => 7680000, 'tags' => ['apparel', 'manufacturing'], 'is_approved' => true, 'download_count' => 41],
        ];

        foreach ($resources as $resource) {
            Resource::create($resource);
        }

        // Update faculty ratings
        $facultyProfiles = FacultyProfile::all();
        foreach ($facultyProfiles as $faculty) {
            $faculty->updateRating();
        }

        echo "Comprehensive database seeding completed!\n";
        echo "Created:\n";
        echo "- " . count($departments) . " departments\n";
        echo "- " . count($courses) . " courses\n";
        echo "- " . count($users) . " users\n";
        echo "- " . count($facultyProfiles) . " faculty profiles\n";
        echo "- " . count($studentGrades) . " student grades\n";
        echo "- " . count($reviews) . " faculty reviews\n";
        echo "- " . count($resources) . " resources\n";
    }
    
    private function getGradePoint($grade)
    {
        $gradePoints = [
            'A+' => 4.00,
            'A' => 3.75,
            'A-' => 3.50,
            'B+' => 3.25,
            'B' => 3.00,
            'B-' => 2.75,
            'C+' => 2.50,
            'C' => 2.25,
            'C-' => 2.00,
            'D+' => 1.75,
            'D' => 1.50,
            'F' => 0.00
        ];
        
        return $gradePoints[$grade] ?? 0;
    }
}
