<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;
use App\Models\AssetImage;

class AssetImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();

        foreach ($assets as $asset) {
            AssetImage::factory()
                ->count(3)
                ->withImage()
                ->create(['asset_id' => $asset->id]);
        }
    }
}
