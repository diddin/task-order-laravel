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
        $tasks = Task::take(10)->get();

        foreach ($tasks as $task) {
            // Buat 3-6 status update acak untuk tiap task
            TaskOrder::factory()
                ->count(rand(3, 6))
                ->create([
                    'task_id' => $task->id,
                ]);
        }
    }
}
