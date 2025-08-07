<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckTables extends Command
{
    protected $signature = 'tables:check';
    protected $description = 'Check database tables';

    public function handle()
    {
        $this->info("Checking tables...");
        
        $tables = ['courses', 'comprehensive_courses', 'student_courses'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $this->info("✓ Table '{$table}' exists with {$count} records");
                
                if ($table === 'comprehensive_courses' && $count > 0) {
                    $sample = DB::table($table)->first();
                    $this->info("  Sample: " . json_encode($sample));
                }
            } else {
                $this->error("✗ Table '{$table}' does not exist");
            }
        }
    }
}
