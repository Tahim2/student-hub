<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;

class CseCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if CSE department exists, create if not
        $cseDepartment = Department::firstOrCreate(
            ['code' => 'CSE'],
            [
                'name' => 'Computer Science and Engineering',
                'description' => 'Department of Computer Science and Engineering'
            ]
        );

        $cseId = $cseDepartment->id;

        // CSE Course Data
        $courses = [
            // Level-1, Term-1
            ['ENG-101', 'Basic Functional English and English Spoken', 'GED Theory', 3, 1, 1],
            ['MAT-101', 'Mathematics - I', 'GED Theory', 3, 1, 1],
            ['CSE-115', 'Introduction to Biology and Chemistry for Computation', 'Core Theory', 3, 1, 1],
            ['CSE-112', 'Computer Fundamentals', 'Core Theory', 3, 1, 1],

            // Level-1, Term-2
            ['ENG-102', 'Writing and Comprehension', 'GED Theory', 3, 1, 2],
            ['MAT-102', 'Mathematics-II: Calculus, Complex Variables and Linear Algebra', 'GED Theory', 3, 1, 2],
            ['CSE-113', 'Programming and Problem Solving', 'Core Theory', 3, 1, 2],
            ['CSE-114', 'Programming and Problem Solving Lab', 'Core Lab', 1.5, 1, 2],
            ['PHY-101', 'Physics-I', 'GED Theory', 3, 1, 2],

            // Level-1, Term-3
            ['PHY-102', 'Physics - II', 'GED Theory', 3, 1, 3],
            ['PHY-103', 'Physics - II Lab', 'GED Lab', 1.5, 1, 3],
            ['CSE-121', 'Electrical Circuits', 'Core Theory', 3, 1, 3],
            ['CSE-122', 'Electrical Circuits Lab', 'Core Lab', 1.5, 1, 3],
            ['CSE-123', 'Data Structure', 'Core Theory', 3, 1, 3],
            ['CSE-124', 'Data Structure Lab', 'Core Lab', 1.5, 1, 3],

            // Level-2, Term-1
            ['MAT-211', 'Engineering Mathematics', 'GED Theory', 3, 2, 1],
            ['CSE-212', 'Discrete Mathematics', 'Core Theory', 3, 2, 1],
            ['CSE-213', 'Algorithms', 'Core Theory', 3, 2, 1],
            ['CSE-214', 'Algorithms Lab', 'Core Lab', 1.5, 2, 1],
            ['BNS-101', 'Bangladesh Studies (History of Independence and Contemporary Issues)', 'GED Theory', 3, 2, 1],

            // Level-2, Term-2
            ['AOL-101', 'Art of Living', 'GED Theory', 3, 2, 2],
            ['CSE-215', 'Electronic Devices and Circuits', 'Core Theory', 3, 2, 2],
            ['CSE-216', 'Electronic Devices and Circuits Lab', 'Core Lab', 1.5, 2, 2],
            ['CSE-221', 'Object Oriented Programming', 'Core Theory', 3, 2, 2],
            ['CSE-222', 'Object Oriented Programming Lab', 'Core Lab', 1.5, 2, 2],

            // Level-2, Term-3
            ['CSE-223', 'Digital Logic Design', 'Core Theory', 3, 2, 3],
            ['CSE-224', 'Digital Logic Design Lab', 'Core Lab', 1.5, 2, 3],
            ['CSE-225', 'Data Communication', 'Core Theory', 3, 2, 3],
            ['CSE-228', 'Theory of Computation', 'Core Theory', 3, 2, 3],
            ['CSE-227', 'Systems Analysis and Design', 'Core Theory', 3, 2, 3],

            // Level-3, Term-1
            ['CSE-226', 'Numerical Methods', 'Core Theory', 3, 3, 1],
            ['CSE-311', 'Database Management System', 'Core Theory', 3, 3, 1],
            ['CSE-312', 'Database Management System Lab', 'Core Lab', 1.5, 3, 1],
            ['CSE-313', 'Compiler Design', 'Core Theory', 3, 3, 1],
            ['CSE-314', 'Compiler Design Lab', 'Core Lab', 1.5, 3, 1],

            // Level-3, Term-2
            ['CSE-315', 'Software Engineering', 'Core Theory', 3, 3, 2],
            ['CSE-317', 'Microprocessor and Microcontrollers', 'Core Theory', 3, 3, 2],
            ['CSE-321', 'Computer Networks', 'Core Theory', 3, 3, 2],
            ['CSE-322', 'Computer Networks Lab', 'Core Lab', 1.5, 3, 2],
            ['ACT-327', 'Financial and Managerial Accounting', 'GED Theory', 3, 3, 2],

            // Level-3, Term-3
            ['STA-101', 'Statistics and Probability', 'GED Theory', 3, 3, 3],
            ['CSE-316', 'Artificial Intelligence', 'Core Theory', 3, 3, 3],
            ['CSE-323', 'Operating Systems', 'Core Theory', 3, 3, 3],
            ['CSE-324', 'Operating Systems Lab', 'Core Lab', 1.5, 3, 3],
            ['CSE-399', 'Elective-I', 'Elective', 3, 3, 3],

            // Level-4, Term-1
            ['CSE-325', 'Instrumentation and Control', 'Core Theory', 3, 4, 1],
            ['CSE-326', 'Social and Professional Issues in Computing', 'Core Theory', 3, 4, 1],
            ['CSE-411', 'Computer Graphics', 'Core Theory', 3, 4, 1],
            ['CSE-412', 'Computer Graphics Lab', 'Core Lab', 1.5, 4, 1],
            ['CSE-499', 'Elective-II', 'Elective', 3, 4, 1],

            // Level-4, Term-2
            ['CSE-413', 'Computer Architecture and Organization', 'Core Theory', 3, 4, 2],
            ['CSE-491', 'Elective-III', 'Elective', 3, 4, 2],
            ['CSE-492', 'Elective-IV', 'Elective', 3, 4, 2],
            ['CSE-498', 'Capstone Project (Phase I)', 'Project', 3, 4, 2],

            // Level-4, Term-3
            ['ECO-426', 'Engineering Economics', 'GED Theory', 3, 4, 3],
            ['CSE-493', 'Elective-V', 'Elective', 3, 4, 3],
            ['CSE-494', 'Elective-VI', 'Elective', 3, 4, 3],
            ['CSE-497', 'Capstone Project (Phase II)', 'Project', 3, 4, 3],
        ];

        $addedCount = 0;
        $skippedCount = 0;

        foreach ($courses as $courseData) {
            [$code, $name, $type, $credits, $level, $term] = $courseData;
            
            // Use firstOrCreate to avoid duplicates
            $course = Course::firstOrCreate(
                ['course_code' => $code],
                [
                    'course_name' => $name,
                    'description' => null,
                    'credits' => $credits,
                    'department_id' => $cseId,
                    'course_type' => $type,
                    'level' => $level,
                    'term' => $term,
                    'prerequisites' => null,
                    'is_active' => true,
                ]
            );

            if ($course->wasRecentlyCreated) {
                $addedCount++;
                $this->command->info("Added: $code - $name");
            } else {
                $skippedCount++;
                $this->command->warn("Skipped (exists): $code - $name");
            }
        }

        $this->command->info("\n=== Summary ===");
        $this->command->info("Total courses processed: " . count($courses));
        $this->command->info("Courses added: $addedCount");
        $this->command->info("Courses skipped (already exist): $skippedCount");
        $this->command->info("\nCSE courses have been successfully added to the database!");
    }
}
