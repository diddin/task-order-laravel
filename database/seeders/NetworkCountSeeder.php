<?php

namespace Database\Seeders;

use App\Models\NetworkCount;
use Illuminate\Support\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NetworkCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            '2025-06' => 300,
            '2025-07' => 400,
            '2025-08' => 500,
        ];

        foreach ($data as $month => $total) {
            NetworkCount::updateOrCreate(
                ['month' => $month],
                ['total' => $total]
            );
        }
    }
}
