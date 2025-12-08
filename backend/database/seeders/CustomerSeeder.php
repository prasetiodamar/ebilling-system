<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customerUsers = User::where('role', 'customer')->get();

        foreach ($customerUsers as $index => $user) {
            Customer::create([
                'user_id' => $user->id,
                'customer_number' => 'CUST-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'full_name' => $user->name,
                'package_type' => ['basic', 'standard', 'premium'][$index % 3],
                'monthly_fee' => [300000, 500000, 1000000][$index % 3],
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12345',
                'status' => 'active',
                'payment_status' => 'pending',
            ]);
        }

        $this->command->info('CustomerSeeder: ' . count($customerUsers) . ' customers created');
    }
}
