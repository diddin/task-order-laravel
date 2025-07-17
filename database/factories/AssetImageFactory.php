<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetImage>
 */
class AssetImageFactory extends Factory
{
    protected $model = AssetImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asset_id' => \App\Models\Asset::inRandomOrder()->first()->id,
            'image_path' => null, // akan diisi di withImage()
        ];
    }
    /**
     * Attach a dummy image from public/dummies/assets to the image_path
     */
    public function withImage()
    {
        return $this->afterCreating(function (AssetImage $assetImage) {
            $dummyDirectory = public_path('dummies/assets');
            $dummyFiles = collect(glob($dummyDirectory . '/*.jpg'));

            if ($dummyFiles->isEmpty()) {
                throw new \Exception("No dummy images found in: $dummyDirectory");
            }

            // Pilih file random dari dummies
            $sourceFile = $dummyFiles->random();
            $filename = Str::random(10) . '.jpg';
            $storagePath = 'asset_images/' . $filename;

            // Simpan ke storage/app/public/asset_images
            Storage::disk('public')->put($storagePath, file_get_contents($sourceFile));

            // Update path di model
            $assetImage->update([
                'image_path' => $storagePath,
            ]);
        });
    }
}
