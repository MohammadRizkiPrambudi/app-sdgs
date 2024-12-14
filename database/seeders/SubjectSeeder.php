<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create(['name' => 'Matematika', 'description' => 'Pelajaran Matematika']);
        Subject::create(['name' => 'Bahasa Indonesia', 'description' => 'Pelajaran Bahasa Indonesia']);
    }
}