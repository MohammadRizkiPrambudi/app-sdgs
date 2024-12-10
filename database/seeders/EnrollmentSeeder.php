<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enrollments')->insert([
            [
                'student_id' => 1,
                'class_id' => 1,
            ],
            [
                'student_id' => 2,
                'class_id' => 2,
            ],
        ]);
    }
}