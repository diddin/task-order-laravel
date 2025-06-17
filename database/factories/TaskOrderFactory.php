<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\TaskOrder;
use \App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskOrder>
 */
class TaskOrderFactory extends Factory
{
    protected $model = TaskOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'task_id' => Task::factory(), // otomatis buat Task baru jika belum disediakan
            'status' => $this->faker->sentence(6), // status acak kalimat pendek
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }
}
