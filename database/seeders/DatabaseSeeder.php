<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this import

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    DB::table('order_items')->truncate();
    DB::table('orders')->truncate();
    DB::table('products')->truncate();
    DB::table('customers')->truncate();
    DB::table('users')->truncate(); // Truncate users table if adding an admin user

    $this->call([
        CustomerSeeder::class,
        ProductSeeder::class,
        OrderSeeder::class,
        AdminUserSeeder::class, // Add this line
    ]);
}
}