<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = Invoice::all();
        $count = 0;

        foreach ($invoices as $invoice) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'payment_number' => 'PAY-' . $invoice->id,
                'payment_method' => 'bank_transfer',
                'payment_gateway' => 'xendit',
                'amount' => $invoice->total_amount * 0.5,
                'status' => 'pending',
                'description' => 'Payment for ' . $invoice->invoice_number,
            ]);
            $count++;
        }

        $this->command->info("PaymentSeeder: $count payments created");
    }
}
