<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            DiscountSeeder::class,
            ProductSeeder::class,
            CategorySeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
        ]);

        Product::find(1)->categories()->attach(Category::find(1)->id);
        Product::find(2)->categories()->attach(Category::find(2)->id);
    }
}
