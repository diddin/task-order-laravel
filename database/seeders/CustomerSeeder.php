<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 1 pelanggan kategori backbone
        Customer::factory()->backbone()->count(1)->create();
        
        //Customer::factory()->count(50)->create(); // membuat 50 data customer
        // Membuat 5 pelanggan kategori akses
        Customer::factory()->akses()->count(499)->create();
    }
}