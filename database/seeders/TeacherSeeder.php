<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::create(['name' => 'Guru Matematika', 'user_id' => 3]);
        Teacher::create(['name' => 'Guru Bahasa Indonesia', 'user_id' => 4]);
    }
}