<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'name'  => 'Diskon Ramadhan Special',
            'code'  => 'AHSJGK2GH',
            'max_used'  => 1000,
            'used'  => 0,
            'minimum_point' => 1000,
            'minimum_purchase_price'  => 1000,
            'categories' => 'paket',
            'minimum_buy_discount' => 2,
            'get_discount' => 3,
            'start_date' => now(),
            'end_date'  => date('Y-m-d', strtotime( "April 29, 2030")),
        ]);
    }
}
