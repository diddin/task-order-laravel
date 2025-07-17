<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Network;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(50)->create();
        
        Task::factory()->create([
            'detail' => 'Install new network equipment at the main office',
            'network_id' => Network::inRandomOrder()->first() ?? Network::factory()->create()->id,
            'assigned_to' => 3,
            'action' => null,
            'created_by' => 2,
        ]);
        Task::factory()->create([
            'detail' => 'Fix network issues at the branch office',
            'network_id' => Network::inRandomOrder()->first() ?? Network::factory()->create()->id,
            'assigned_to' => 3,
            'action' => null,
            'created_by' => 2,
        ]);
        Task::factory()->create([
            'detail' => 'Upgrade network infrastructure to support higher bandwidth',
            'network_id' => Network::inRandomOrder()->first() ?? Network::factory()->create()->id,
            'assigned_to' => 3,
            'action' => null,
            'created_by' => 2,
        ]);
    }
}
