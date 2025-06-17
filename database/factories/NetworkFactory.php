<?php

namespace Database\Factories;

use App\Models\Network;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Network>
 */
class NetworkFactory extends Factory
{
    protected $model = Network::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'network_number' => $this->faker->ipv4,
            'detail' => $this->faker->sentence,
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
        ];
    }
}
