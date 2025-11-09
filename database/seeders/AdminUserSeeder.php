<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure the User model is imported
use Illuminate\Support\Facades\Hash; // Import Hash for password

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Use a strong password
            'is_admin' => true,
        ]);
    }
}