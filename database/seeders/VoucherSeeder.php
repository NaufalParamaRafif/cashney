<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::create([
            'code' => 'DISCOUNT10',
            'max_used' => 23,
            'expired_date' => date('Y-m-d', strtotime( "April 29, 2030")),
            'discount_percentage' => 10.00,
        ]);
    }
}
