<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => Hash::make('password123'),
                'grade' => '1',
            ],
            [
                'name' => 'Bob Lee',
                'email' => 'bob.lee@example.com',
                'password' => Hash::make('password123'),
                'grade' => '2',
            ],
        ]);
    }
}