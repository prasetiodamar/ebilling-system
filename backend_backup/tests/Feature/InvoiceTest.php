<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Invoice;

class InvoiceTest extends TestCase
{
    protected $user;
    protected $token;
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
        $this->token = $this->user->createToken('test-token')->plainTextToken;
        $this->customer = Customer::factory()->create();
    }

    /**
     * Test get all invoices
     */
    public function test_get_all_invoices()
    {
        Invoice::factory()->count(5)->create(['customer_id' => $this->customer->id]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson('/api/invoices');

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
                'pagination',
            ]);
    }

    /**
     * Test create invoice
     */
    public function test_create_invoice()
    {
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson('/api/invoices', [
                'customer_id' => $this->customer->id,
                'invoice_number' => 'INV-001',
                'invoice_date' => now()->toDateString(),
                'due_date' => now()->addDays(30)->toDateString(),
                'subtotal' => 1000000,
                'tax' => 100000,
                'discount' => 0,
                'description' => 'Monthly subscription',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'invoice_number',
                    'total_amount',
                    'status',
                ],
            ]);

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => 'INV-001',
            'customer_id' => $this->customer->id,
        ]);
    }

    /**
     * Test show invoice
     */
    public function test_show_invoice()
    {
        $invoice = Invoice::factory()->create(['customer_id' => $this->customer->id]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'invoice_number',
                    'status',
                    'total_amount',
                    'customer',
                    'payments',
                ],
            ]);
    }

    /**
     * Test update invoice
     */
    public function test_update_invoice()
    {
        $invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'draft',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->putJson("/api/invoices/{$invoice->id}", [
                'due_date' => now()->addDays(45)->toDateString(),
                'subtotal' => 1500000,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Invoice updated successfully',
            ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'subtotal' => 1500000,
        ]);
    }

    /**
     * Test cannot update non-draft invoice
     */
    public function test_cannot_update_sent_invoice()
    {
        $invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'sent',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->putJson("/api/invoices/{$invoice->id}", [
                'subtotal' => 2000000,
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Only draft invoices can be updated',
            ]);
    }

    /**
     * Test send invoice
     */
    public function test_send_invoice()
    {
        $invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'draft',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/invoices/{$invoice->id}/send");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Invoice sent successfully',
            ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'sent',
        ]);
    }

    /**
     * Test mark invoice as paid
     */
    public function test_mark_invoice_as_paid()
    {
        $invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'sent',
            'total_amount' => 1000000,
            'paid_amount' => 0,
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/invoices/{$invoice->id}/mark-as-paid", [
                'amount' => 1000000,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Invoice payment recorded successfully',
            ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'paid_amount' => 1000000,
            'status' => 'paid',
        ]);
    }

    /**
     * Test cancel invoice
     */
    public function test_cancel_invoice()
    {
        $invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'sent',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/invoices/{$invoice->id}/cancel");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Invoice cancelled successfully',
            ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'cancelled',
        ]);
    }

    /**
     * Test get invoices by customer
     */
    public function test_get_invoices_by_customer()
    {
        Invoice::factory()->count(3)->create(['customer_id' => $this->customer->id]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/invoices/customer/{$this->customer->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'invoice_number',
                        'status',
                    ],
                ],
            ]);
    }

    /**
     * Test delete invoice
     */
    public function test_delete_invoice()
    {
        $invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'status' => 'draft',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson("/api/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Invoice deleted successfully',
            ]);

        $this->assertSoftDeleted('invoices', [
            'id' => $invoice->id,
        ]);
    }
}
