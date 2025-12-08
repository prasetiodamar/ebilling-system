<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = ['bank_transfer', 'credit_card', 'debit_card', 'e_wallet', 'cash', 'check'];
        $paymentGateways = ['xendit', 'tripay', 'moota', null];
        $statuses = ['pending', 'processing', 'completed', 'failed', 'refunded'];

        $paidInvoices = Invoice::where('status', 'paid')->orWhere('status', 'partial')->get();
        $paymentCount = 0;

        foreach ($paidInvoices as $invoice) {
            // Create 1-2 payments per paid/partial invoice
            $paymentsForInvoice = rand(1, 2);

            for ($i = 0; $i < $paymentsForInvoice; $i++) {
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                $paymentGateway = in_array($paymentMethod, ['bank_transfer', 'credit_card', 'debit_card', 'e_wallet'])
                    ? $paymentGateways[array_rand($paymentGateways)]
                    : null;

                $amount = $invoice->total_amount / $paymentsForInvoice;
                $status = $invoice->status === 'paid' ? 'completed' : ['pending', 'processing', 'completed'][$i % 3];

                $paymentDate = null;
                if ($status === 'completed') {
                    $paymentDate = $invoice->invoice_date->copy()->addDays(rand(1, 20));
                }

                $gatewayResponse = null;
                if ($paymentGateway === 'xendit') {
                    $gatewayResponse = [
                        'id' => 'xendit_' . uniqid(),
                        'external_id' => 'payment_' . $invoice->id . '_' . $i,
                        'user_id' => rand(1, 1000),
                        'is_closed' => $status === 'completed',
                        'status' => $status === 'completed' ? 'COMPLETED' : 'PENDING',
                        'reference_id' => 'ref_' . uniqid(),
                        'business_id' => rand(1, 100),
                        'currency' => 'IDR',
                        'amount' => $amount,
                    ];
                } elseif ($paymentGateway === 'tripay') {
                    $gatewayResponse = [
                        'success' => $status === 'completed',
                        'message' => $status === 'completed' ? 'Payment successful' : 'Payment pending',
                        'data' => [
                            'reference' => 'tripay_' . uniqid(),
                            'merchant_ref' => 'payment_' . $invoice->id . '_' . $i,
                            'payment_method' => $paymentMethod,
                            'payment_name' => ucfirst(str_replace('_', ' ', $paymentMethod)),
                            'customer_name' => $invoice->customer->full_name,
                            'customer_email' => $invoice->customer->user->email,
                            'order_items' => [
                                [
                                    'sku' => $invoice->customer->package_type,
                                    'name' => 'ISP Service - ' . $invoice->customer->package_type,
                                    'price' => $amount,
                                    'quantity' => 1,
                                ],
                            ],
                            'amount' => $amount,
                            'pay_code' => 'TRIPAY' . rand(1000000, 9999999),
                            'pay_url' => 'https://tripay.co.id/checkout/' . uniqid(),
                            'expires_at' => now()->addDays(1)->timestamp,
                            'expired_time' => now()->addDays(1)->timestamp,
                            'status' => $status === 'completed' ? 'PAID' : 'UNPAID',
                        ],
                    ];
                }

                Payment::create([
                    'invoice_id' => $invoice->id,
                    'customer_id' => $invoice->customer_id,
                    'payment_number' => 'PAY-' . $invoice->id . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'payment_method' => $paymentMethod,
                    'payment_gateway' => $paymentGateway,
                    'gateway_reference_id' => $paymentGateway ? 'ref_' . uniqid() : null,
                    'amount' => $amount,
                    'status' => $status,
                    'payment_date' => $paymentDate,
                    'description' => "Payment for invoice {$invoice->invoice_number}",
                    'gateway_response' => $gatewayResponse,
                ]);

                $paymentCount++;
            }
        }

        $this->command->info("PaymentSeeder: Created $paymentCount payments");
    }
}
