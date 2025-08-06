<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\FacultyCourseAssignment;
use App\Models\Department;

class FacultyCourseAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample departments if they don't exist
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CSE'],
            ['name' => 'Business Administration', 'code' => 'BBA'],
            ['name' => 'Electrical Engineering', 'code' => 'EEE'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }

        $cseDept = Department::where('code', 'CSE')->first();

        // Create sample faculty users
        $faculties = [
            [
                'name' => 'Dr. John Smith',
                'email' => 'john.smith@diu.edu.bd',
                'password' => bcrypt('password'),
                'role' => 'faculty',
                'department_id' => $cseDept->id,
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@diu.edu.bd',
                'password' => bcrypt('password'),
                'role' => 'faculty',
                'department_id' => $cseDept->id,
            ],
            [
                'name' => 'Prof. Michael Brown',
                'email' => 'michael.brown@diu.edu.bd',
                'password' => bcrypt('password'),
                'role' => 'faculty',
                'department_id' => $cseDept->id,
            ],
        ];

        foreach ($faculties as $faculty) {
            User::firstOrCreate(['email' => $faculty['email']], $faculty);
        }

        // Create sample courses
        $courses = [
            [
                'course_code' => 'CSE101',
                'course_name' => 'Introduction to Programming',
                'description' => 'Basic programming concepts and C++ programming',
                'credits' => 3.0,
                'department_id' => $cseDept->id,
                'course_type' => 'Core Theory',
                'level' => 1,
                'term' => 1,
                'is_active' => true,
            ],
            [
                'course_code' => 'CSE102',
                'course_name' => 'Data Structures',
                'description' => 'Linear and non-linear data structures',
                'credits' => 3.0,
                'department_id' => $cseDept->id,
                'course_type' => 'Core Theory',
                'level' => 1,
                'term' => 2,
                'is_active' => true,
            ],
            [
                'course_code' => 'CSE201',
                'course_name' => 'Object Oriented Programming',
                'description' => 'OOP concepts using Java',
                'credits' => 3.0,
                'department_id' => $cseDept->id,
                'course_type' => 'Core Theory',
                'level' => 2,
                'term' => 1,
                'is_active' => true,
            ],
            [
                'course_code' => 'CSE202',
                'course_name' => 'Database Management Systems',
                'description' => 'Database design and SQL',
                'credits' => 3.0,
                'department_id' => $cseDept->id,
                'course_type' => 'Core Theory',
                'level' => 2,
                'term' => 2,
                'is_active' => true,
            ],
            [
                'course_code' => 'CSE301',
                'course_name' => 'Software Engineering',
                'description' => 'Software development methodologies',
                'credits' => 3.0,
                'department_id' => $cseDept->id,
                'course_type' => 'Core Theory',
                'level' => 3,
                'term' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['course_code' => $course['course_code']], $course);
        }

        // Create faculty course assignments for Spring 2025
        $johnSmith = User::where('email', 'john.smith@diu.edu.bd')->first();
        $sarahJohnson = User::where('email', 'sarah.johnson@diu.edu.bd')->first();
        $michaelBrown = User::where('email', 'michael.brown@diu.edu.bd')->first();

        $cse101 = Course::where('course_code', 'CSE101')->first();
        $cse102 = Course::where('course_code', 'CSE102')->first();
        $cse201 = Course::where('course_code', 'CSE201')->first();
        $cse202 = Course::where('course_code', 'CSE202')->first();
        $cse301 = Course::where('course_code', 'CSE301')->first();

        $assignments = [
            [
                'faculty_id' => $johnSmith->id,
                'course_id' => $cse101->id,
                'semester' => 'Spring 2025',
                'academic_year' => 2025,
                'semester_type' => 'Spring',
                'is_active' => true,
            ],
            [
                'faculty_id' => $johnSmith->id,
                'course_id' => $cse201->id,
                'semester' => 'Spring 2025',
                'academic_year' => 2025,
                'semester_type' => 'Spring',
                'is_active' => true,
            ],
            [
                'faculty_id' => $sarahJohnson->id,
                'course_id' => $cse102->id,
                'semester' => 'Spring 2025',
                'academic_year' => 2025,
                'semester_type' => 'Spring',
                'is_active' => true,
            ],
            [
                'faculty_id' => $sarahJohnson->id,
                'course_id' => $cse202->id,
                'semester' => 'Spring 2025',
                'academic_year' => 2025,
                'semester_type' => 'Spring',
                'is_active' => true,
            ],
            [
                'faculty_id' => $michaelBrown->id,
                'course_id' => $cse301->id,
                'semester' => 'Spring 2025',
                'academic_year' => 2025,
                'semester_type' => 'Spring',
                'is_active' => true,
            ],
        ];

        foreach ($assignments as $assignment) {
            FacultyCourseAssignment::firstOrCreate(
                [
                    'faculty_id' => $assignment['faculty_id'],
                    'course_id' => $assignment['course_id'],
                    'semester' => $assignment['semester'],
                    'academic_year' => $assignment['academic_year']
                ],
                $assignment
            );
        }

        $this->command->info('Faculty course assignments seeded successfully!');
    }
}
