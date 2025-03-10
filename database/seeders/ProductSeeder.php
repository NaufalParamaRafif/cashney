<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Smartphone',
            'image' => 'masbro.jpg',
            'price' => 1499000.43,
            'supply' => 50,
        ]);

        Product::create([
            'name' => 'T-shirt',
            'image' => 'masbro.jpg',
            'price' => 190233.25,
            'supply' => 200,
        ]);
    }
}
