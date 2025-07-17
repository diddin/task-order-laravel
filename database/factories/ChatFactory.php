<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $sender = true;
        $sender = !$sender;

        $from = $sender ? 2 : 3;
        $to   = $sender ? 3 : 3;

        return [
            'from_user_id' => $from,
            'to_user_id' => $to,
            'message' => $this->faker->sentence,
            'created_at' => Carbon::now()->subDays(rand(0, 5))->setTime(rand(8, 17), rand(0, 59)),
        ];
    }
}
