<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'role' => 'admin', 'password' => Hash::make('password123')]);
        User::create(['name' => 'Siswa 1', 'email' => 'siswa1@example.com', 'role' => 'siswa', 'password' => Hash::make('password123')]);
        User::create(['name' => 'Guru Matematika', 'email' => 'guru.mat@example.com', 'role' => 'teacher', 'password' => Hash::make('password123')]);
        User::create(['name' => 'Guru Bahasa Indonesia', 'email' => 'guru.bahasa@example.com', 'role' => 'teacher', 'password' => Hash::make('password123')]);
    }
}