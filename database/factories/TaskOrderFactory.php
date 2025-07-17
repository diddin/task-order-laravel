<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\TaskOrder;
use \App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            'task_id'    => Task::factory(), // buat Task baru otomatis
            'status'     => $this->faker->sentence(6),
            'image'      => null,
            'latitude'   => $this->faker->latitude(-90, 90),
            'longitude'  => $this->faker->longitude(-180, 180),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }

    public function withImage()
    {
        $dummies = [
            public_path('dummies/dummy1.jpg'),
            public_path('dummies/dummy2.jpg'),
            public_path('dummies/dummy3.jpg'),
        ];
    
        $randomDummy = $dummies[array_rand($dummies)];

        $filename = Str::random(10) . '.jpg';
        $storagePath = 'images/' . $filename;

        Storage::put($storagePath, File::get($randomDummy));

        return $this->state(fn () => [
            'image' => 'images/' . $filename,
        ]);
    }
}
