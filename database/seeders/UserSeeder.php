<?php


// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@platform.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Mentor
        $mentor = User::create([
            'name' => 'Mentor User',
            'email' => 'mentor@platform.com',
            'password' => Hash::make('password'),
        ]);
        $mentor->assignRole('mentor');

        // Student
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@platform.com',
            'password' => Hash::make('password'),
        ]);
        $student->assignRole('student');
    }
}
