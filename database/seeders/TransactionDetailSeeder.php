<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionDetail;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionDetail::create([
            'product_total' => 1,
            'price_per_item' => 1000,
            'subtotal' => 1000,
            'transaction_code' => 'TRANSAKTI',
            'product_name' => 'Makanan Bergizi Fiesta',
            'discount_code' => 'DISAK47',
            'transaction_id' => 1,
            'product_id' => 1,
            'discount_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
