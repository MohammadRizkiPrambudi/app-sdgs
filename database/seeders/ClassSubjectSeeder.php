<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_subject')->insert([
            ['class_id' => 1, 'subject_id' => 1],
            ['class_id' => 1, 'subject_id' => 2],
        ]);
    }
}