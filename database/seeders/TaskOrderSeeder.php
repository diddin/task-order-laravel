<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskOrder;
use App\Models\Task;

class TaskOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil 10 task pertama (atau sesuai kebutuhan)
        //$tasks = Task::take(10)->get();

        $tasks = Task::all();

        // foreach ($tasks as $task) {
        //     // Buat 3-6 status update acak untuk tiap task
        //     TaskOrder::factory()
        //         ->count(rand(3, 6))
        //         ->create([
        //             'task_id' => $task->id,
        //         ]);
        // }

        foreach ($tasks as $task) {
            $count = rand(3, 6);
            for ($i = 0; $i < $count; $i++) {
                $factory = TaskOrder::factory();
        
                // 30% chance ada gambar
                if (rand(1, 10) <= 3) {
                    $factory = $factory->withImage();
                }
        
                $factory->create([
                    'task_id' => $task->id,
                ]);
            }
        }
    }
}
