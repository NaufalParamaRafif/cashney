<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'price_total' => 519.98,
            'customer_id' => 1,
            'cashier_id' => 2,
            'customer_email' => 'johndoe@gmail.com',
            'cashier_email' => 'azkaaurel@gmail.com',
        ]);
    }
}
