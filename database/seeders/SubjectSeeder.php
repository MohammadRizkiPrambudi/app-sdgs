<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            [
                'name' => 'Mathematics',
                'description' => 'Study of numbers',
            ],
            [
                'name' => 'Science',
                'description' => 'Study of natural phenomena',
            ],
        ]);
    }
}