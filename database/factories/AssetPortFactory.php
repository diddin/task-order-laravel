<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetPort;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetPort>
 */
class AssetPortFactory extends Factory
{
    protected $model = AssetPort::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asset_id' => Asset::inRandomOrder()->first()?->id,
            'port' => 'PORT ' . $this->faker->unique()->numberBetween(1, 100),
            'jumper_id' => null, // default null, diatur kemudian
        ];
    }
}
