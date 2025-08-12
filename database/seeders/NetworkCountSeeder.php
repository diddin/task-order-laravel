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
            '2025-06' => 70,
            '2025-07' => 80,
            '2025-08' => 90,
        ];

        foreach ($data as $month => $total) {
            NetworkCount::updateOrCreate(
                ['month' => $month],
                ['total' => $total]
            );
        }
    }
}
