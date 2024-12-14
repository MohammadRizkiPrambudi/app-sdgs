<?php

namespace Database\Seeders;

use Database\Seeders\ClassSeeder;
use Database\Seeders\MaterialSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\TeacherSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([

            UserSeeder::class,
            TeacherSeeder::class,
            ClassSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            ClassSubjectSeeder::class,
            MaterialSeeder::class,
        ]);
    }
}