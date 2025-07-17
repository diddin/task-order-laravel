<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Network;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        // Cari role 'technician'
        $technicianRoleId = Role::where('name', 'technician')->first()?->id;

        // Cari user dengan role 1 atau 2 untuk created_by
        $createdBy = User::whereIn('role_id', [1, 2])->inRandomOrder()->first();

        // Jika tidak ada, buat user baru dengan role 1 (misal admin)
        if (!$createdBy) {
            $createdBy = User::factory()->create(['role_id' => 1]);
        }
        
        $network = Network::inRandomOrder()->first() ?? Network::factory()->create();

        // List action (null termasuk)
        $actions = [null, 'in progress', 'completed'];

        return [
            'detail' => $this->faker->sentence(),
            'network_id' => $network->id,
            'created_by' => $createdBy->id,
            'action' => $this->faker->randomElement($actions),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            // Cari role technician
            $technicianRoleId = Role::where('name', 'technician')->first()?->id;

            // Ambil 1 PIC dan 1-2 tim onsite
            $users = User::where('role_id', $technicianRoleId)->inRandomOrder()->take(3)->get();

            if ($users->isEmpty()) {
                // Buat user jika belum ada
                $users = User::factory(3)->create(['role_id' => $technicianRoleId]);
            }

            $assignments = [];

            foreach ($users as $index => $user) {
                $assignments[$user->id] = [
                    'role_in_task' => $index === 0 ? 'pic' : 'onsite',
                ];
            }

            $task->assignedUsers()->attach($assignments);
        });
    }
}
