<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    /**
     * Test get all customers
     */
    public function test_get_all_customers()
    {
        Customer::factory()->count(5)->create();

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'customer_number',
                        'full_name',
                        'package_type',
                        'status',
                    ],
                ],
                'pagination' => [
                    'total',
                    'per_page',
                    'current_page',
                    'last_page',
                ],
            ]);
    }

    /**
     * Test create customer
     */
    public function test_create_customer()
    {
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson('/api/customers', [
                'user_id' => $this->user->id,
                'customer_number' => 'CUST-001',
                'full_name' => 'PT Maju Jaya',
                'package_type' => 'standard',
                'monthly_fee' => 500000,
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 1',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12345',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'customer_number',
                    'full_name',
                    'package_type',
                    'monthly_fee',
                ],
            ]);

        $this->assertDatabaseHas('customers', [
            'customer_number' => 'CUST-001',
            'full_name' => 'PT Maju Jaya',
        ]);
    }

    /**
     * Test show customer
     */
    public function test_show_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'customer_number',
                    'full_name',
                    'status',
                    'user',
                    'invoices',
                    'payments',
                ],
            ]);
    }

    /**
     * Test update customer
     */
    public function test_update_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->putJson("/api/customers/{$customer->id}", [
                'full_name' => 'Updated Name',
                'phone' => '089876543210',
                'status' => 'inactive',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Customer updated successfully',
            ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'full_name' => 'Updated Name',
            'status' => 'inactive',
        ]);
    }

    /**
     * Test suspend customer
     */
    public function test_suspend_customer()
    {
        $customer = Customer::factory()->create(['status' => 'active']);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/customers/{$customer->id}/suspend");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Customer suspended successfully',
            ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'status' => 'suspended',
        ]);
    }

    /**
     * Test activate customer
     */
    public function test_activate_customer()
    {
        $customer = Customer::factory()->create(['status' => 'suspended']);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/customers/{$customer->id}/activate");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Customer activated successfully',
            ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'status' => 'active',
        ]);
    }

    /**
     * Test get customer invoices
     */
    public function test_get_customer_invoices()
    {
        $customer = Customer::factory()->create();
        $customer->invoices()->createMany([
            ['invoice_number' => 'INV-001', 'invoice_date' => now(), 'due_date' => now()->addDays(30), 'subtotal' => 1000000, 'total_amount' => 1000000],
            ['invoice_number' => 'INV-002', 'invoice_date' => now(), 'due_date' => now()->addDays(30), 'subtotal' => 500000, 'total_amount' => 500000],
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/customers/{$customer->id}/invoices");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'invoice_number',
                        'status',
                        'total_amount',
                    ],
                ],
            ]);
    }

    /**
     * Test delete customer
     */
    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Customer deleted successfully',
            ]);

        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    }
}
