<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'John Doe',
            'gender' => 'Pria',
            'birth_date' => date('Y-m-d', strtotime( "April 29, 2000")),
            'point' => 1000,
            'address' => '123 Main Street',
            'email' => 'johndoe@gmail.com',
            'phone_number' => '081234567890',
        ]);
    }
}
