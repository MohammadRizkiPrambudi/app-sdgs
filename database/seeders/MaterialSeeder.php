<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::create([
            'title' => 'Materi Matematika Bab 1',
            'content' => 'Pengenalan Aljabar',
            'class_id' => 1,
            'subject_id' => 1,
        ]);
        Material::create([
            'title' => 'Materi Bahasa Indonesia Bab 1',
            'content' => 'Mengenal Puisi',
            'class_id' => 1,
            'subject_id' => 2,
        ]);
    }
}