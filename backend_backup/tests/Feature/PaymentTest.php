<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;

class PaymentTest extends TestCase
{
    protected $user;
    protected $token;
    protected $customer;
    protected $invoice;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
        $this->token = $this->user->createToken('test-token')->plainTextToken;
        $this->customer = Customer::factory()->create();
        $this->invoice = Invoice::factory()->create([
            'customer_id' => $this->customer->id,
            'total_amount' => 1000000,
        ]);
    }

    /**
     * Test get all payments
     */
    public function test_get_all_payments()
    {
        Payment::factory()->count(5)->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson('/api/payments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'payment_number',
                        'amount',
                        'status',
                    ],
                ],
                'pagination',
            ]);
    }

    /**
     * Test create payment
     */
    public function test_create_payment()
    {
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson('/api/payments', [
                'invoice_id' => $this->invoice->id,
                'payment_number' => 'PAY-001',
                'payment_method' => 'bank_transfer',
                'payment_gateway' => 'xendit',
                'amount' => 500000,
                'description' => 'Payment for invoice INV-001',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'payment_number',
                    'amount',
                    'status',
                ],
            ]);

        $this->assertDatabaseHas('payments', [
            'payment_number' => 'PAY-001',
            'invoice_id' => $this->invoice->id,
            'status' => 'pending',
        ]);
    }

    /**
     * Test show payment
     */
    public function test_show_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson("/api/payments/{$payment->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'payment_number',
                    'amount',
                    'status',
                    'invoice',
                    'customer',
                ],
            ]);
    }

    /**
     * Test complete payment
     */
    public function test_complete_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'status' => 'pending',
            'amount' => 500000,
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/payments/{$payment->id}/complete");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Payment completed successfully',
            ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'completed',
        ]);
    }

    /**
     * Test cannot complete non-pending payment
     */
    public function test_cannot_complete_completed_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'status' => 'completed',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/payments/{$payment->id}/complete");

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Only pending payments can be completed',
            ]);
    }

    /**
     * Test refund payment
     */
    public function test_refund_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'status' => 'completed',
            'amount' => 500000,
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/payments/{$payment->id}/refund");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Payment refunded successfully',
            ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'refunded',
        ]);
    }

    /**
     * Test cannot refund non-completed payment
     */
    public function test_cannot_refund_pending_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson("/api/payments/{$payment->id}/refund");

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Only completed payments can be refunded',
            ]);
    }

    /**
     * Test get payments by gateway
     */
    public function test_get_payments_by_gateway()
    {
        Payment::factory()->count(3)->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'payment_gateway' => 'xendit',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson('/api/payments/gateway/xendit');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'payment_number',
                        'payment_gateway',
                    ],
                ],
            ]);
    }

    /**
     * Test delete payment
     */
    public function test_delete_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'status' => 'pending',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson("/api/payments/{$payment->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Payment deleted successfully',
            ]);

        $this->assertSoftDeleted('payments', [
            'id' => $payment->id,
        ]);
    }

    /**
     * Test cannot delete completed payment
     */
    public function test_cannot_delete_completed_payment()
    {
        $payment = Payment::factory()->create([
            'customer_id' => $this->customer->id,
            'invoice_id' => $this->invoice->id,
            'status' => 'completed',
        ]);

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson("/api/payments/{$payment->id}");

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Only pending payments can be deleted',
            ]);
    }
}
