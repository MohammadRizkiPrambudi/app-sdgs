<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classes::create(['name' => 'Kelas 1A', 'teacher_id' => 1]);
        Classes::create(['name' => 'Kelas 1B', 'teacher_id' => 2]);
    }
}