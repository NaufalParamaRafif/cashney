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
            CategorySeeder::class,
            ProductSeeder::class,
            VoucherSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
        ]);

        Product::find(1)->categories()->attach(Category::find(1)->id);
        Product::find(2)->categories()->attach(Category::find(2)->id);

        DB::table('voucher_transaction')->insert([
            'voucher_code' => 'DISCOUNT10',
            'voucher_id' => 1,
            'transaction_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
