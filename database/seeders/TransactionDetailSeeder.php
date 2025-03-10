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
            'subtotal' => 1499000.99,
            'product_name' => 'Smartphone',
            'product_id' => 1,
            'transaction_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
