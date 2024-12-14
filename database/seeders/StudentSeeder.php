<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create(['name' => 'Siswa 1', 'user_id' => 1, 'class_id' => 1]);
        Student::create(['name' => 'Siswa 2', 'user_id' => 2, 'class_id' => 1]);
    }
}