<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@ebilling.local',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Operator Support',
            'email' => 'operator@ebilling.local',
            'password' => Hash::make('operator123'),
            'role' => 'operator',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::factory(5)->create(['role' => 'customer', 'status' => 'active', 'email_verified_at' => now()]);

        $this->command->info('UserSeeder: 7 users created');
    }
}
