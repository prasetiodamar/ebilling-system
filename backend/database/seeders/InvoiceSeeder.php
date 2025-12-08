<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $count = 0;

        foreach ($customers as $customer) {
            for ($i = 0; $i < 2; $i++) {
                $subtotal = $customer->monthly_fee;
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;

                Invoice::create([
                    'customer_id' => $customer->id,
                    'invoice_number' => 'INV-' . $customer->id . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'invoice_date' => now()->subDays(rand(0, 30)),
                    'due_date' => now()->addDays(rand(1, 30)),
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => 0,
                    'total_amount' => $total,
                    'paid_amount' => 0,
                    'status' => 'sent',
                    'description' => 'Monthly service subscription',
                ]);
                $count++;
            }
        }

        $this->command->info("InvoiceSeeder: $count invoices created");
    }
}
