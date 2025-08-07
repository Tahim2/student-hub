<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;
use App\Models\Semester;

class CSECurriculumSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create CSE Department
        $cseDepartment = Department::firstOrCreate([
            'name' => 'Computer Science & Engineering',
            'code' => 'CSE',
            'description' => 'Computer Science and Engineering Department'
        ]);

        // Create semesters for different years
        $semesters = [
            ['name' => 'Spring 2023', 'code' => 'S23', 'start_date' => '2023-01-15', 'end_date' => '2023-05-15'],
            ['name' => 'Summer 2023', 'code' => 'U23', 'start_date' => '2023-06-01', 'end_date' => '2023-08-31'],
            ['name' => 'Fall 2023', 'code' => 'F23', 'start_date' => '2023-09-01', 'end_date' => '2023-12-15'],
            ['name' => 'Spring 2024', 'code' => 'S24', 'start_date' => '2024-01-15', 'end_date' => '2024-05-15'],
            ['name' => 'Summer 2024', 'code' => 'U24', 'start_date' => '2024-06-01', 'end_date' => '2024-08-31'],
            ['name' => 'Fall 2024', 'code' => 'F24', 'start_date' => '2024-09-01', 'end_date' => '2024-12-15'],
            ['name' => 'Spring 2025', 'code' => 'S25', 'start_date' => '2025-01-15', 'end_date' => '2025-05-15'],
            ['name' => 'Summer 2025', 'code' => 'U25', 'start_date' => '2025-06-01', 'end_date' => '2025-08-31'],
            ['name' => 'Fall 2025', 'code' => 'F25', 'start_date' => '2025-09-01', 'end_date' => '2025-12-15', 'is_current' => true],
        ];

        foreach ($semesters as $semester) {
            Semester::firstOrCreate(['code' => $semester['code']], $semester);
        }

        // CSE Curriculum - All courses for 4 levels
        $cseCoursesData = [
            // Level 1, Term 1
            ['course_code' => 'ENG-101', 'course_name' => 'Basic Functional English and English Spoken', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 1, 'semester_term' => 1],
            ['course_code' => 'MAT-101', 'course_name' => 'Mathematics - I', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 1, 'semester_term' => 1],
            ['course_code' => 'CSE-115', 'course_name' => 'Introduction to Biology and Chemistry for Computation', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 1, 'semester_term' => 1],
            ['course_code' => 'CSE-112', 'course_name' => 'Computer Fundamentals', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 1, 'semester_term' => 1],

            // Level 1, Term 2
            ['course_code' => 'ENG-102', 'course_name' => 'Writing and Comprehension', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 1, 'semester_term' => 2],
            ['course_code' => 'MAT-102', 'course_name' => 'Mathematics-II: Calculus, Complex Variables and Linear Algebra', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 1, 'semester_term' => 2],
            ['course_code' => 'CSE-113', 'course_name' => 'Programming and Problem Solving', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 1, 'semester_term' => 2],
            ['course_code' => 'CSE-114', 'course_name' => 'Programming and Problem Solving Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 1, 'semester_term' => 2],
            ['course_code' => 'PHY-101', 'course_name' => 'Physics-I', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 1, 'semester_term' => 2],

            // Level 1, Term 3
            ['course_code' => 'PHY-102', 'course_name' => 'Physics - II', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 1, 'semester_term' => 3],
            ['course_code' => 'PHY-103', 'course_name' => 'Physics - II Lab', 'credits' => 1.5, 'course_type' => 'GED Lab', 'semester_level' => 1, 'semester_term' => 3],
            ['course_code' => 'CSE-121', 'course_name' => 'Electrical Circuits', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 1, 'semester_term' => 3],
            ['course_code' => 'CSE-122', 'course_name' => 'Electrical Circuits Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 1, 'semester_term' => 3],
            ['course_code' => 'CSE-123', 'course_name' => 'Data Structure', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 1, 'semester_term' => 3],
            ['course_code' => 'CSE-124', 'course_name' => 'Data Structure Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 1, 'semester_term' => 3],

            // Level 2, Term 1
            ['course_code' => 'MAT-211', 'course_name' => 'Engineering Mathematics', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 2, 'semester_term' => 1],
            ['course_code' => 'CSE-212', 'course_name' => 'Discrete Mathematics', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 1],
            ['course_code' => 'CSE-213', 'course_name' => 'Algorithms', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 1],
            ['course_code' => 'CSE-214', 'course_name' => 'Algorithms Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 2, 'semester_term' => 1],
            ['course_code' => 'BNS-101', 'course_name' => 'Bangladesh Studies (History of Independence and Contemporary Issues)', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 2, 'semester_term' => 1],

            // Level 2, Term 2
            ['course_code' => 'AOL-101', 'course_name' => 'Art of Living', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 2, 'semester_term' => 2],
            ['course_code' => 'CSE-215', 'course_name' => 'Electronic Devices and Circuits', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 2],
            ['course_code' => 'CSE-216', 'course_name' => 'Electronic Devices and Circuits Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 2, 'semester_term' => 2],
            ['course_code' => 'CSE-221', 'course_name' => 'Object Oriented Programming', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 2],
            ['course_code' => 'CSE-222', 'course_name' => 'Object Oriented Programming Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 2, 'semester_term' => 2],

            // Level 2, Term 3
            ['course_code' => 'CSE-223', 'course_name' => 'Digital Logic Design', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 3],
            ['course_code' => 'CSE-224', 'course_name' => 'Digital Logic Design Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 2, 'semester_term' => 3],
            ['course_code' => 'CSE-225', 'course_name' => 'Data Communication', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 3],
            ['course_code' => 'CSE-228', 'course_name' => 'Theory of Computation', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 3],
            ['course_code' => 'CSE-227', 'course_name' => 'Systems Analysis and Design', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 2, 'semester_term' => 3],

            // Level 3, Term 1
            ['course_code' => 'CSE-226', 'course_name' => 'Numerical Methods', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 1],
            ['course_code' => 'CSE-311', 'course_name' => 'Database Management System', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 1],
            ['course_code' => 'CSE-312', 'course_name' => 'Database Management System Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 3, 'semester_term' => 1],
            ['course_code' => 'CSE-313', 'course_name' => 'Compiler Design', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 1],
            ['course_code' => 'CSE-314', 'course_name' => 'Compiler Design Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 3, 'semester_term' => 1],

            // Level 3, Term 2
            ['course_code' => 'CSE-315', 'course_name' => 'Software Engineering', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 2],
            ['course_code' => 'CSE-317', 'course_name' => 'Microprocessor and Microcontrollers', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 2],
            ['course_code' => 'CSE-321', 'course_name' => 'Computer Networks', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 2],
            ['course_code' => 'CSE-322', 'course_name' => 'Computer Networks Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 3, 'semester_term' => 2],
            ['course_code' => 'ACT-327', 'course_name' => 'Financial and Managerial Accounting', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 3, 'semester_term' => 2],

            // Level 3, Term 3
            ['course_code' => 'STA-101', 'course_name' => 'Statistics and Probability', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 3, 'semester_term' => 3],
            ['course_code' => 'CSE-316', 'course_name' => 'Artificial Intelligence', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 3],
            ['course_code' => 'CSE-323', 'course_name' => 'Operating Systems', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 3],
            ['course_code' => 'CSE-324', 'course_name' => 'Operating Systems Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 3, 'semester_term' => 3],
            ['course_code' => 'CSE-331', 'course_name' => 'Elective-I', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 3, 'semester_term' => 3],

            // Level 4, Term 1
            ['course_code' => 'CSE-325', 'course_name' => 'Instrumentation and Control', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 1],
            ['course_code' => 'CSE-326', 'course_name' => 'Social and Professional Issues in Computing', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 1],
            ['course_code' => 'CSE-411', 'course_name' => 'Computer Graphics', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 1],
            ['course_code' => 'CSE-412', 'course_name' => 'Computer Graphics Lab', 'credits' => 1.5, 'course_type' => 'Core Lab', 'semester_level' => 4, 'semester_term' => 1],
            ['course_code' => 'CSE-431', 'course_name' => 'Elective-II', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 1],

            // Level 4, Term 2
            ['course_code' => 'CSE-413', 'course_name' => 'Computer Architecture and Organization', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 2],
            ['course_code' => 'CSE-432', 'course_name' => 'Elective-III', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 2],
            ['course_code' => 'CSE-433', 'course_name' => 'Elective-IV', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 2],
            ['course_code' => 'CSE-498', 'course_name' => 'Capstone Project (Phase I)', 'credits' => 3, 'course_type' => 'Project', 'semester_level' => 4, 'semester_term' => 2],

            // Level 4, Term 3
            ['course_code' => 'ECO-426', 'course_name' => 'Engineering Economics', 'credits' => 3, 'course_type' => 'GED Theory', 'semester_level' => 4, 'semester_term' => 3],
            ['course_code' => 'CSE-434', 'course_name' => 'Elective-V', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 3],
            ['course_code' => 'CSE-435', 'course_name' => 'Elective-VI', 'credits' => 3, 'course_type' => 'Core Theory', 'semester_level' => 4, 'semester_term' => 3],
            ['course_code' => 'CSE-499', 'course_name' => 'Capstone Project (Phase II)', 'credits' => 3, 'course_type' => 'Project', 'semester_level' => 4, 'semester_term' => 3],
        ];

        // Create CSE courses
        foreach ($cseCoursesData as $courseData) {
            Course::firstOrCreate(
                ['course_code' => $courseData['course_code']],
                array_merge($courseData, [
                    'department_id' => $cseDepartment->id,
                    'level' => 'undergraduate',
                    'description' => $courseData['course_name'],
                    'is_active' => true
                ])
            );
        }

        echo "CSE curriculum seeded successfully!\n";
        echo "Created " . count($cseCoursesData) . " CSE courses across 4 levels.\n";
    }
}
