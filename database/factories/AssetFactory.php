<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'validation_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'data_collection_time' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'location' => $this->faker->address(),
            'code' => $this->faker->unique()->word(),
            'name' => $this->faker->word(),
            'label' => $this->faker->word(),
            'object_type' => $this->faker->randomElement(['POP', 'OLT', 'Splitter']),
            'construction_location' => $this->faker->address(),
            'potential_problem' => $this->faker->sentence(),
            'improvement_recomendation' => $this->faker->sentence(),
            'detail_improvement_recomendation' => $this->faker->paragraph(),
            'pop' => $this->faker->word(),
            'olt' => $this->faker->word(),
            'number_of_ports' => $this->faker->numberBetween(0, 48),
            'number_of_registered_ports' => $this->faker->numberBetween(0, 48),
            'number_of_registered_labels' => $this->faker->numberBetween(0, 48), // typo mengikuti model
            'network_id' => \App\Models\Network::inRandomOrder()->first()?->id,
        ];
    }
}
