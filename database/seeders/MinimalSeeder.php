<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create only the CSE department without courses
        DB::table('departments')->insert([
            'name' => 'Computer Science and Engineering',
            'code' => 'CSE',
            'description' => 'Department of Computer Science and Engineering',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        echo "CSE Department created successfully!\n";
    }
}
