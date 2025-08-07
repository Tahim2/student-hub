<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create CSE department
        $cseDepartment = DB::table('departments')->where('code', 'CSE')->first();
        
        if (!$cseDepartment) {
            $cseDepartmentId = DB::table('departments')->insertGetId([
                'name' => 'Computer Science and Engineering',
                'code' => 'CSE',
                'description' => 'Department of Computer Science and Engineering',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $cseDepartmentId = $cseDepartment->id;
        }
        
        $courses = [
            // Level 1, Term 1
            ['course_code' => 'ENG-101', 'course_name' => 'Basic Functional English and English Spoken', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 1, 'term' => 1],
            ['course_code' => 'MAT-101', 'course_name' => 'Mathematics - I', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 1, 'term' => 1],
            ['course_code' => 'CSE-115', 'course_name' => 'Introduction to Biology and Chemistry for Computation', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 1, 'term' => 1],
            ['course_code' => 'CSE-112', 'course_name' => 'Computer Fundamentals', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 1, 'term' => 1],
            
            // Level 1, Term 2
            ['course_code' => 'ENG-102', 'course_name' => 'Writing and Comprehension', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 1, 'term' => 2],
            ['course_code' => 'MAT-102', 'course_name' => 'Mathematics-II: Calculus, Complex Variables and Linear Algebra', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 1, 'term' => 2],
            ['course_code' => 'CSE-113', 'course_name' => 'Programming and Problem Solving', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 1, 'term' => 2],
            ['course_code' => 'CSE-114', 'course_name' => 'Programming and Problem Solving Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 1, 'term' => 2],
            ['course_code' => 'PHY-101', 'course_name' => 'Physics-I', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 1, 'term' => 2],
            
            // Level 1, Term 3
            ['course_code' => 'PHY-102', 'course_name' => 'Physics - II', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 1, 'term' => 3],
            ['course_code' => 'PHY-103', 'course_name' => 'Physics - II Lab', 'course_type' => 'GED Lab', 'credits' => 1.5, 'level' => 1, 'term' => 3],
            ['course_code' => 'CSE-121', 'course_name' => 'Electrical Circuits', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 1, 'term' => 3],
            ['course_code' => 'CSE-122', 'course_name' => 'Electrical Circuits Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 1, 'term' => 3],
            ['course_code' => 'CSE-123', 'course_name' => 'Data Structure', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 1, 'term' => 3],
            ['course_code' => 'CSE-124', 'course_name' => 'Data Structure Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 1, 'term' => 3],
            
            // Level 2, Term 1
            ['course_code' => 'MAT-211', 'course_name' => 'Engineering Mathematics', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 2, 'term' => 1],
            ['course_code' => 'CSE-212', 'course_name' => 'Discrete Mathematics', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 1],
            ['course_code' => 'CSE-213', 'course_name' => 'Algorithms', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 1],
            ['course_code' => 'CSE-214', 'course_name' => 'Algorithms Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 2, 'term' => 1],
            ['course_code' => 'BNS-101', 'course_name' => 'Bangladesh Studies (History of Independence and Contemporary Issues)', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 2, 'term' => 1],
            
            // Level 2, Term 2
            ['course_code' => 'AOL-101', 'course_name' => 'Art of Living', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 2, 'term' => 2],
            ['course_code' => 'CSE-215', 'course_name' => 'Electronic Devices and Circuits', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 2],
            ['course_code' => 'CSE-216', 'course_name' => 'Electronic Devices and Circuits Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 2, 'term' => 2],
            ['course_code' => 'CSE-221', 'course_name' => 'Object Oriented Programming', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 2],
            ['course_code' => 'CSE-222', 'course_name' => 'Object Oriented Programming Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 2, 'term' => 2],
            
            // Level 2, Term 3
            ['course_code' => 'CSE-223', 'course_name' => 'Digital Logic Design', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 3],
            ['course_code' => 'CSE-224', 'course_name' => 'Digital Logic Design Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 2, 'term' => 3],
            ['course_code' => 'CSE-225', 'course_name' => 'Data Communication', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 3],
            ['course_code' => 'CSE-228', 'course_name' => 'Theory of Computation', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 3],
            ['course_code' => 'CSE-227', 'course_name' => 'Systems Analysis and Design', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 2, 'term' => 3],
            
            // Level 3, Term 1
            ['course_code' => 'CSE-226', 'course_name' => 'Numerical Methods', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 1],
            ['course_code' => 'CSE-311', 'course_name' => 'Database Management System', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 1],
            ['course_code' => 'CSE-312', 'course_name' => 'Database Management System Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 3, 'term' => 1],
            ['course_code' => 'CSE-313', 'course_name' => 'Compiler Design', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 1],
            ['course_code' => 'CSE-314', 'course_name' => 'Compiler Design Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 3, 'term' => 1],
            
            // Level 3, Term 2
            ['course_code' => 'CSE-315', 'course_name' => 'Software Engineering', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 2],
            ['course_code' => 'CSE-317', 'course_name' => 'Microprocessor and Microcontrollers', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 2],
            ['course_code' => 'CSE-321', 'course_name' => 'Computer Networks', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 2],
            ['course_code' => 'CSE-322', 'course_name' => 'Computer Networks Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 3, 'term' => 2],
            ['course_code' => 'ACT-327', 'course_name' => 'Financial and Managerial Accounting', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 3, 'term' => 2],
            
            // Level 3, Term 3
            ['course_code' => 'STA-101', 'course_name' => 'Statistics and Probability', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 3, 'term' => 3],
            ['course_code' => 'CSE-316', 'course_name' => 'Artificial Intelligence', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 3],
            ['course_code' => 'CSE-323', 'course_name' => 'Operating Systems', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 3, 'term' => 3],
            ['course_code' => 'CSE-324', 'course_name' => 'Operating Systems Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 3, 'term' => 3],
            
            // Level 4, Term 1
            ['course_code' => 'CSE-325', 'course_name' => 'Instrumentation and Control', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 4, 'term' => 1],
            ['course_code' => 'CSE-326', 'course_name' => 'Social and Professional Issues in Computing', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 4, 'term' => 1],
            ['course_code' => 'CSE-411', 'course_name' => 'Computer Graphics', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 4, 'term' => 1],
            ['course_code' => 'CSE-412', 'course_name' => 'Computer Graphics Lab', 'course_type' => 'Core Lab', 'credits' => 1.5, 'level' => 4, 'term' => 1],
            
            // Level 4, Term 2
            ['course_code' => 'CSE-413', 'course_name' => 'Computer Architecture and Organization', 'course_type' => 'Core Theory', 'credits' => 3, 'level' => 4, 'term' => 2],
            ['course_code' => 'CSE-498', 'course_name' => 'Capstone Project (Phase I)', 'course_type' => 'Project', 'credits' => 3, 'level' => 4, 'term' => 2],
            
            // Level 4, Term 3
            ['course_code' => 'ECO-426', 'course_name' => 'Engineering Economics', 'course_type' => 'GED Theory', 'credits' => 3, 'level' => 4, 'term' => 3],
            ['course_code' => 'CSE-499', 'course_name' => 'Capstone Project (Phase II)', 'course_type' => 'Project', 'credits' => 3, 'level' => 4, 'term' => 3],
        ];
        
        foreach ($courses as $course) {
            DB::table('courses')->insert([
                'course_code' => $course['course_code'],
                'course_name' => $course['course_name'],
                'course_type' => $course['course_type'],
                'credits' => $course['credits'],
                'level' => $course['level'],
                'term' => $course['term'],
                'department_id' => $cseDepartmentId,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
