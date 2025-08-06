<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComprehensiveCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // Level 1 Term 1
            ['code' => 'ENG-101', 'title' => 'Comprehensive English', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'MATH-101', 'title' => 'Differential and Integral Calculus', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-110', 'title' => 'Programming Language I (C)', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-111', 'title' => 'Programming Language I Lab (C)', 'type' => 'lab', 'credits' => 1.5, 'level' => 1, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'PHY-101', 'title' => 'Physics I (Mechanics, Wave and Optics)', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'PHY-102', 'title' => 'Physics I Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 1, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],

            // Level 1 Term 2
            ['code' => 'ENG-102', 'title' => 'English Composition and Communication Skills', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'MATH-102', 'title' => 'Linear Algebra and Complex Variable', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-120', 'title' => 'Programming Language II (C++)', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-121', 'title' => 'Programming Language II Lab (C++)', 'type' => 'lab', 'credits' => 1.5, 'level' => 1, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'PHY-103', 'title' => 'Physics II (Electricity, Magnetism and modern physics)', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'PHY-104', 'title' => 'Physics II Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 1, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],

            // Level 1 Term 3
            ['code' => 'MATH-103', 'title' => 'Co-ordinate Geometry and Vector Analysis', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-130', 'title' => 'Discrete Mathematics', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-131', 'title' => 'Digital Logic Design', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-132', 'title' => 'Digital Logic Design Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 1, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'STA-101', 'title' => 'Statistics & Probability', 'type' => 'core', 'credits' => 3.0, 'level' => 1, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],

            // Level 2 Term 1
            ['code' => 'MATH-201', 'title' => 'Differential Equation and Special Functions', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-210', 'title' => 'Data Structure and Algorithm I', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-211', 'title' => 'Data Structure and Algorithm I Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 2, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-220', 'title' => 'Computer Architecture', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'ECO-101', 'title' => 'Economics', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],

            // Level 2 Term 2
            ['code' => 'MATH-202', 'title' => 'Numerical Analysis', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-221', 'title' => 'Data Structure and Algorithm II', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-222', 'title' => 'Data Structure and Algorithm II Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 2, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-230', 'title' => 'Electronics for Computer Science', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-231', 'title' => 'Electronics for Computer Science Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 2, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'HUM-103', 'title' => 'Philosophy', 'type' => 'core', 'credits' => 2.0, 'level' => 2, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],

            // Level 2 Term 3
            ['code' => 'CSE-240', 'title' => 'Object Oriented Programming (Java)', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-241', 'title' => 'Object Oriented Programming Lab (Java)', 'type' => 'lab', 'credits' => 1.5, 'level' => 2, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-250', 'title' => 'Microprocessors and Assembly Language', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-251', 'title' => 'Microprocessors and Assembly Language Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 2, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-260', 'title' => 'Database Systems', 'type' => 'core', 'credits' => 3.0, 'level' => 2, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-261', 'title' => 'Database Systems Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 2, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],

            // Level 3 Term 1
            ['code' => 'CSE-310', 'title' => 'Compiler', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-311', 'title' => 'Compiler Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-320', 'title' => 'Computer Networks', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-321', 'title' => 'Computer Networks Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-330', 'title' => 'Operating Systems and System Programming', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-331', 'title' => 'Operating Systems and System Programming Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],

            // Level 3 Term 2
            ['code' => 'CSE-340', 'title' => 'Software Engineering', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-341', 'title' => 'Software Engineering Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-350', 'title' => 'Computer Graphics', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-351', 'title' => 'Computer Graphics Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-360', 'title' => 'Artificial Intelligence', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-361', 'title' => 'Artificial Intelligence Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],

            // Level 3 Term 3
            ['code' => 'CSE-370', 'title' => 'Web Programming', 'type' => 'core', 'credits' => 3.0, 'level' => 3, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-371', 'title' => 'Web Programming Lab', 'type' => 'lab', 'credits' => 1.5, 'level' => 3, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
            ['code' => 'CSE-380', 'title' => 'Option I', 'type' => 'elective', 'credits' => 3.0, 'level' => 3, 'term' => 3, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-381', 'title' => 'Option I Lab', 'type' => 'elective', 'credits' => 1.5, 'level' => 3, 'term' => 3, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-382', 'title' => 'Option II', 'type' => 'elective', 'credits' => 3.0, 'level' => 3, 'term' => 3, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-383', 'title' => 'Option II Lab', 'type' => 'elective', 'credits' => 1.5, 'level' => 3, 'term' => 3, 'department' => 'CSE', 'is_elective' => true],

            // Level 4 Term 1
            ['code' => 'CSE-410', 'title' => 'Option III', 'type' => 'elective', 'credits' => 3.0, 'level' => 4, 'term' => 1, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-411', 'title' => 'Option III Lab', 'type' => 'elective', 'credits' => 1.5, 'level' => 4, 'term' => 1, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-420', 'title' => 'Option IV', 'type' => 'elective', 'credits' => 3.0, 'level' => 4, 'term' => 1, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-421', 'title' => 'Option IV Lab', 'type' => 'elective', 'credits' => 1.5, 'level' => 4, 'term' => 1, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-498', 'title' => 'Project/Thesis', 'type' => 'project', 'credits' => 3.0, 'level' => 4, 'term' => 1, 'department' => 'CSE', 'is_elective' => false],

            // Level 4 Term 2
            ['code' => 'CSE-430', 'title' => 'Option V', 'type' => 'elective', 'credits' => 3.0, 'level' => 4, 'term' => 2, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-431', 'title' => 'Option V Lab', 'type' => 'elective', 'credits' => 1.5, 'level' => 4, 'term' => 2, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-440', 'title' => 'Option VI', 'type' => 'elective', 'credits' => 3.0, 'level' => 4, 'term' => 2, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-441', 'title' => 'Option VI Lab', 'type' => 'elective', 'credits' => 1.5, 'level' => 4, 'term' => 2, 'department' => 'CSE', 'is_elective' => true],
            ['code' => 'CSE-499', 'title' => 'Project/Thesis', 'type' => 'project', 'credits' => 3.0, 'level' => 4, 'term' => 2, 'department' => 'CSE', 'is_elective' => false],

            // Level 4 Term 3
            ['code' => 'CSE-490', 'title' => 'Internship/Viva Voce', 'type' => 'internship', 'credits' => 3.0, 'level' => 4, 'term' => 3, 'department' => 'CSE', 'is_elective' => false],
        ];

        foreach ($courses as $course) {
            DB::table('comprehensive_courses')->insert($course);
        }
    }
}
