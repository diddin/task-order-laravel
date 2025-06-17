<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_taskorder_list()
    {
        TaskOrder::factory()->count(2)->create();

        $response = $this->get(route('taskorders.index'));

        $response->assertStatus(200);
        $response->assertSee('Task'); // Sesuaikan dengan konten di view index
    }

    public function test_user_can_access_create_form()
    {
        $response = $this->get(route('taskorders.create'));

        $response->assertStatus(200);
        $response->assertSee('Create'); // Sesuaikan dengan isi view create
    }

    public function test_user_can_store_taskorder()
    {
        $task = Task::factory()->create();

        $data = [
            'task_id' => $task->id,
            'status' => "13:00 Teknisi mulai pengerjaan.",
        ];

        $response = $this->post(route('taskorders.store'), $data);

        $response->assertRedirect(route('taskorders.index'));
        $this->assertDatabaseHas('task_orders', $data);
    }

    public function test_user_can_view_taskorder_detail()
    {
        $taskOrder = TaskOrder::factory()->create();

        $response = $this->get(route('taskorders.show', $taskOrder));

        $response->assertStatus(200);
        $response->assertSee($taskOrder->status);
    }

    public function test_user_can_access_edit_form()
    {
        $taskOrder = TaskOrder::factory()->create();

        $response = $this->get(route('taskorders.edit', $taskOrder));

        $response->assertStatus(200);
        $response->assertSee($taskOrder->status);
    }

    public function test_user_can_update_taskorder()
    {
        $taskOrder = TaskOrder::factory()->create([
            'status' => 'Awal status'
        ]);

        $updated = [
            'task_id' => $taskOrder->task_id,
            'status' => 'Status baru jam 14:10 Pengecekan selesai.',
        ];

        $response = $this->put(route('taskorders.update', $taskOrder->id), $updated);

        $response->assertRedirect(route('taskorders.show', $taskOrder));
        //$this->assertDatabaseHas('task_orders', ['status' => 'Status baru jam 14:10 Pengecekan selesai.']);

        $this->assertDatabaseHas('task_orders', [
            'id' => $taskOrder->id,
            'status' => $updated['status'], // pastikan nilai cocok
        ]);
    }

    public function test_user_can_delete_taskorder()
    {
        $taskOrder = TaskOrder::factory()->create();

        $response = $this->delete(route('taskorders.destroy', $taskOrder));

        $response->assertRedirect(route('taskorders.index'));
        $this->assertDatabaseMissing('task_orders', ['id' => $taskOrder->id]);
    }
}
