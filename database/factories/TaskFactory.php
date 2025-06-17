<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Network;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $technicianRoleId = Role::where('name', 'technician')->first()->id;
        $createdBy = User::inRandomOrder()->first() ?? User::factory()->create();
        $network = Network::inRandomOrder()->first() ?? Network::factory()->create();
        $assignedTo = User::where('role_id', $technicianRoleId)->inRandomOrder()
        ->first()?->id;

        $actions = ['null', 'in progress', 'completed'];

        return [
            'detail' => $this->faker->sentence(),
            'network_id' => $network->id,
            'assigned_to' => $assignedTo,
            'created_by' => $createdBy->id,
            'action' => $actions[array_rand($actions)],
        ];
    }
}
