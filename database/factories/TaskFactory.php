<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        // Pilih kategori secara acak
        $category = $this->faker->randomElement(['akses', 'backbone']);

        $createdBy = User::whereIn('role_id', [1, 2])->inRandomOrder()->first()
            ?? User::factory()->create(['role_id' => 1]);

        if ($category === 'backbone') {
            // Pakai customer ID = 1 untuk backbone
            $customer = Customer::find(1);

            // Jika belum ada, buat dulu dengan ID 1
            if (!$customer) {
                $customer = Customer::factory()->backbone()->create(['id' => 1]);
            }
        } else {
            // Ambil customer akses, selain ID 1
            $customer = Customer::where('category', 'akses')
                                ->where('id', '!=', 1)
                                ->inRandomOrder()
                                ->first()
                        ?? Customer::factory()->akses()->create();
        }

        $actions = [null, 'in progress', 'completed'];

        return [
            'task_number' => $this->faker->unique()->numerify('TASK-####'),
            'detail'      => $this->faker->sentence(),
            'category'    => $category,
            'customer_id' => $customer->id,
            'created_by'  => $createdBy->id,
            'action'      => $this->faker->randomElement($actions),
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
