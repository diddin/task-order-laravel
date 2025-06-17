<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Optional: create user with role and login
        $this->user = User::factory()->create();
        $this->actingAs($this->user); // Login user
    }

    public function test_user_can_view_customer_list()
    {
        Customer::factory()->count(3)->create();

        $response = $this->get(route('customers.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Customer'); // atau gunakan nama customer dari factory
    }

    public function test_user_can_create_customer()
    {
        $response = $this->get(route('customers.create'));
        $response->assertStatus(200);

        $data = [
            'name' => 'PT Sumber Jaya',
            'address' => 'Jl. Cendrawasih No.9',
        ];

        $post = $this->post(route('customers.store'), $data);
        $post->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', $data);
    }

    public function test_user_can_view_customer_detail()
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.show', $customer));
        $response->assertStatus(200);
        $response->assertSee($customer->name);
    }

    public function test_user_can_edit_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.edit', $customer));
        $response->assertStatus(200);
        $response->assertSee('value="' . $customer->name . '"');
    }

    public function test_user_can_update_customer()
    {
        $customer = Customer::factory()->create([
            'name' => 'PT Lama',
        ]);

        $updateData = [
            'name' => 'PT Baru',
            'address' => 'Alamat Baru',
        ];

        $response = $this->put(route('customers.update', $customer), $updateData);
        $response->assertRedirect(route('customers.index'));

        $this->assertDatabaseHas('customers', $updateData);
    }

    public function test_user_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('customers.destroy', $customer));
        $response->assertRedirect(route('customers.index'));

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
