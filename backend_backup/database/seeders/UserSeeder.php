<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@ebilling.local',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Operator user
        User::create([
            'name' => 'Operator Support',
            'email' => 'operator@ebilling.local',
            'password' => Hash::make('operator123'),
            'phone' => '081234567891',
            'address' => 'Jakarta, Indonesia',
            'role' => 'operator',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Test customers
        User::factory(5)->create([
            'role' => 'customer',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $this->command->info('UserSeeder: Created 7 users (1 admin, 1 operator, 5 customers)');
    }
}
