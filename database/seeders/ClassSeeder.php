<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            [
                'name' => 'Kelas 1-A',
                'teacher_id' => 1,
                'subject_id' => 1,
            ],
            [
                'name' => 'Kelas 2-B',
                'teacher_id' => 2,
                'subject_id' => 2,
            ],
        ]);
    }
}