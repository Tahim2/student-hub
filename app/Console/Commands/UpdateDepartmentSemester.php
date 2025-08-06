<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Department;

class UpdateDepartmentSemester extends Command
{
    protected $signature = 'dept:update-semester';
    protected $description = 'Update department semester types';

    public function handle()
    {
        // Update CSE department
        $cseDept = Department::where('code', 'CSE')->first();
        if ($cseDept) {
            $cseDept->update(['semester_type' => 'trisemester']);
            $this->info("Updated CSE department to trisemester");
        }
        
        // List all departments and their semester types
        $departments = Department::all();
        foreach ($departments as $dept) {
            $this->info("{$dept->code} - " . ($dept->semester_type ?: 'no type set'));
        }
    }
}
