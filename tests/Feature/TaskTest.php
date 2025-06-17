<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Network;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Autentikasi pengguna
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_task_list()
    {
        Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertSee('Task'); // Sesuaikan dengan isi tampilan index.blade.php
    }

    public function test_user_can_view_task_create_form()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertSee('Create'); // Sesuaikan dengan konten view create
    }

    public function test_user_can_store_task()
    {
        $network = Network::factory()->create();
        $assignedUser = User::factory()->create();

        $data = [
            'detail' => 'Pemasangan baru',
            'network_id' => $network->id,
            'assigned_to' => $assignedUser->id,
            'action' => 'in progress',
        ];

        $response = $this->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'detail' => 'Pemasangan baru',
            'network_id' => $network->id,
            'assigned_to' => $assignedUser->id,
            'created_by' => $this->user->id,
        ]);
    }

    public function test_user_can_view_task_detail()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));
        $response->assertStatus(200);
        $response->assertSee($task->detail);
    }

    public function test_user_can_view_task_edit_form()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));
        $response->assertStatus(200);
        $response->assertSee($task->detail);
    }

    public function test_user_can_update_task()
    {
        $task = Task::factory()->create([
            'detail' => 'Old Detail'
        ]);

        $updateData = [
            'detail' => 'Updated Task Detail',
            'network_id' => $task->network_id,
            'assigned_to' => $task->assigned_to,
            'action' => 'completed',
        ];

        $response = $this->put(route('tasks.update', $task), $updateData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['detail' => 'Updated Task Detail']);
    }

    public function test_user_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
