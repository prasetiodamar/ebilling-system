<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packagePrices = [
            'basic' => 300000,
            'standard' => 500000,
            'premium' => 1000000,
        ];

        // Create customers for each customer user
        $customerUsers = User::where('role', 'customer')->get();

        foreach ($customerUsers as $index => $user) {
            $packageType = array_keys($packagePrices)[$index % 3];
            
            Customer::create([
                'user_id' => $user->id,
                'customer_number' => 'CUST-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'full_name' => $user->name,
                'package_type' => $packageType,
                'monthly_fee' => $packagePrices[$packageType],
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12345',
                'status' => ['active', 'active', 'inactive', 'suspended', 'active'][$index % 5],
                'payment_status' => ['paid', 'pending', 'overdue', 'paid', 'pending'][$index % 5],
                'last_payment_date' => now()->subDays(rand(1, 30)),
                'next_billing_date' => now()->addDays(rand(1, 30)),
                'balance' => rand(0, 1000000),
                'router_mac_address' => 'AA:BB:CC:' . str_pad(dechex($index), 2, '0', STR_PAD_LEFT) . ':' . str_pad(dechex($index + 1), 2, '0', STR_PAD_LEFT) . ':' . str_pad(dechex($index + 2), 2, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('CustomerSeeder: Created ' . count($customerUsers) . ' customers');
    }
}
