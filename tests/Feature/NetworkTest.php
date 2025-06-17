<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Network;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NetworkTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_network_list()
    {
        Network::factory()->count(3)->create();

        $response = $this->get(route('networks.index'));

        $response->assertStatus(200);
        $response->assertSee('Network'); // Ubah sesuai teks di view
    }

    public function test_user_can_create_network()
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('networks.create'));
        $response->assertStatus(200);
        $response->assertSee($customer->name);

        $data = [
            'network_number' => 'NET-001',
            'detail' => 'Modem Huawei',
            'customer_id' => $customer->id,
        ];

        $store = $this->post(route('networks.store'), $data);
        $store->assertRedirect(route('networks.index'));
        $this->assertDatabaseHas('networks', $data);
    }

    public function test_user_can_view_single_network()
    {
        $network = Network::factory()->create();

        $response = $this->get(route('networks.show', $network));
        $response->assertStatus(200);
        $response->assertSee($network->network_number);
    }

    public function test_user_can_edit_network()
    {
        $network = Network::factory()->create();

        $response = $this->get(route('networks.edit', $network));
        $response->assertStatus(200);
        $response->assertSee($network->network_number);
    }

    public function test_user_can_update_network()
    {
        $network = Network::factory()->create();

        $updateData = [
            'network_number' => 'NET-UPDATED',
            'detail' => 'Updated detail',
            'customer_id' => $network->customer_id,
        ];

        $response = $this->put(route('networks.update', $network), $updateData);
        $response->assertRedirect(route('networks.index'));
        $this->assertDatabaseHas('networks', $updateData);
    }

    public function test_user_can_delete_network()
    {
        $network = Network::factory()->create();

        $response = $this->delete(route('networks.destroy', $network));
        $response->assertRedirect(route('networks.index'));

        $this->assertDatabaseMissing('networks', ['id' => $network->id]);
    }
}
