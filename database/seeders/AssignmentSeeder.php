<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignments')->insert([
            ['title' => 'Tambah dan Kurang',
                'description' => 'Pelajari dasar-dasar penjumlahan dan pengurangan.',
                'class_id' => 1,
            ],
            [
                'title' => 'Pengenalan Tumbuhan',
                'description' => 'Pelajari tentang berbagai jenis tumbuhan.',
                'class_id' => 2,
            ],
        ]);
    }
}