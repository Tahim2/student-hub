<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckCourses extends Command
{
    protected $signature = 'courses:check';
    protected $description = 'Check courses in database';

    public function handle()
    {
        $this->info("Total courses: " . DB::table('courses')->count());
        $this->info("Total departments: " . DB::table('departments')->count());

        $departments = DB::table('departments')->get(['id', 'name', 'code']);
        foreach ($departments as $dept) {
            $courseCount = DB::table('courses')->where('department_id', $dept->id)->count();
            $this->info("Department: {$dept->name} ({$dept->code}) - {$courseCount} courses");
        }

        $this->info("\nSample CSE courses:");
        $cseCourses = DB::table('courses')
            ->join('departments', 'courses.department_id', '=', 'departments.id')
            ->where('departments.code', 'CSE')
            ->select('courses.course_code', 'courses.course_name', 'courses.level', 'courses.term', 'courses.credits')
            ->orderBy('courses.level')
            ->orderBy('courses.term')
            ->limit(10)
            ->get();

        foreach ($cseCourses as $course) {
            $this->info("{$course->course_code} - {$course->course_name} (Level {$course->level}, Term {$course->term}, Credits {$course->credits})");
        }
    }
}
