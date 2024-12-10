<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert([
            [
                'title' => 'Materi Matematika 1',
                'content' => 'Ini adalah materi untuk kelas 1.',
                'class_id' => 1,
            ],
            [
                'title' => 'Materi IPA 2',
                'content' => 'Ini adalah materi untuk kelas 2.',
                'class_id' => 2,
            ],
        ]);
    }
}