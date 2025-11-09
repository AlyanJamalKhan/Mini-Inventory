<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob.brown@example.com',
            ],
        ];

        foreach ($customers as $customerData) {
            DB::table('customers')->insert($customerData);
        }
    }
}