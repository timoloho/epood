<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'price' => 10.00,
        ]);

        Product::create([
            'name' => 'Product 2',
            'price' => 20.00,
        ]);

        Product::create([
            'name' => 'Product 3',
            'price' => 25.00,
        ]);

        Product::create([
            'name' => 'Product 4',
            'price' => 60.00,
        ]);

        Product::create([
            'name' => 'Product 5',
            'price' => 5.00,
        ]);

        Product::create([
            'name' => 'Product 6',
            'price' => 50.00,
        ]);

        Product::create([
            'name' => 'Product 7',
            'price' => 40.00,
        ]);

        Product::create([
            'name' => 'Product 8',
            'price' => 30.00,
        ]);

        Product::create([
            'name' => 'Product 9',
            'price' => 15.00,
        ]);
    }
}
