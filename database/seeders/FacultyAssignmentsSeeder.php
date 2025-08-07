<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\FacultyCourseAssignment;
use App\Models\Department;

class FacultyAssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some faculty members if they don't exist
        $facultyMembers = [
            ['name' => 'Dr. Sarah Johnson', 'email' => 'sarah.johnson@university.edu'],
            ['name' => 'Prof. Michael Chen', 'email' => 'michael.chen@university.edu'],
            ['name' => 'Dr. Emily Rodriguez', 'email' => 'emily.rodriguez@university.edu'],
            ['name' => 'Prof. David Wilson', 'email' => 'david.wilson@university.edu'],
            ['name' => 'Dr. Lisa Thompson', 'email' => 'lisa.thompson@university.edu'],
            ['name' => 'Prof. James Anderson', 'email' => 'james.anderson@university.edu'],
            ['name' => 'Dr. Rachel Martinez', 'email' => 'rachel.martinez@university.edu'],
            ['name' => 'Prof. Robert Taylor', 'email' => 'robert.taylor@university.edu'],
        ];

        // Get CSE department
        $cseDepartment = Department::where('code', 'CSE')->first();
        if (!$cseDepartment) {
            $this->command->error('CSE Department not found. Please run CseCoursesSeeder first.');
            return;
        }

        $createdFaculty = [];
        foreach ($facultyMembers as $facultyData) {
            $faculty = User::firstOrCreate(
                ['email' => $facultyData['email']],
                [
                    'name' => $facultyData['name'],
                    'password' => bcrypt('password123'),
                    'role' => 'faculty',
                    'department_id' => $cseDepartment->id,
                    'email_verified_at' => now(),
                ]
            );
            $createdFaculty[] = $faculty;
            
            if ($faculty->wasRecentlyCreated) {
                $this->command->info("Created faculty: " . $faculty->name);
            }
        }

        // Get Level 4, Term 1 courses (current semester based on the screenshot)
        $level4Term1Courses = Course::where('level', 4)
            ->where('term', 1)
            ->where('department_id', $cseDepartment->id)
            ->get();

        if ($level4Term1Courses->isEmpty()) {
            $this->command->error('No Level 4, Term 1 courses found. Please run CseCoursesSeeder first.');
            return;
        }

        // Current academic year and semester
        $currentYear = 2025;
        $currentSemester = 'Summer'; // Based on the screenshot showing "Level 4 - Summer (Semester 11)"

        $assignmentCount = 0;
        $facultyIndex = 0;

        foreach ($level4Term1Courses as $course) {
            // Assign a faculty member to each course
            $faculty = $createdFaculty[$facultyIndex % count($createdFaculty)];
            
            $assignment = FacultyCourseAssignment::firstOrCreate(
                [
                    'faculty_id' => $faculty->id,
                    'course_id' => $course->id,
                    'academic_year' => $currentYear,
                    'semester_type' => $currentSemester,
                ],
                [
                    'semester' => 11, // Based on the screenshot
                    'is_active' => true,
                ]
            );

            if ($assignment->wasRecentlyCreated) {
                $assignmentCount++;
                $this->command->info("Assigned {$faculty->name} to {$course->course_code} - {$course->course_name}");
            }

            $facultyIndex++;
        }

        $this->command->info("\n=== Summary ===");
        $this->command->info("Faculty members created/verified: " . count($createdFaculty));
        $this->command->info("Course assignments created: $assignmentCount");
        $this->command->info("Faculty assignments have been successfully added!");
    }
}
