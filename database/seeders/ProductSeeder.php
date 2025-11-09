<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Products
        $products = [
            [
                'name' => 'Laptop',
                'price' => 999.99,
                'stock' => 10,
            ],
            [
                'name' => 'Mouse',
                'price' => 25.50,
                'stock' => 50,
            ],
            [
                'name' => 'Keyboard',
                'price' => 75.00,
                'stock' => 30,
            ],
            [
                'name' => 'Monitor',
                'price' => 299.99,
                'stock' => 15,
            ],
            [
                'name' => 'USB Cable',
                'price' => 10.00,
                'stock' => 100,
            ],
        ];

        foreach ($products as $productData) {
            DB::table('products')->insert($productData);
        }
    }
}