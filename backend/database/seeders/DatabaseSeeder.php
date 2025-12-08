<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');
        $startTime = now();

        // Jalankan seeder sesuai urutan yang benar
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            InvoiceSeeder::class,
            PaymentSeeder::class,
        ]);

        $duration = now()->diffInSeconds($startTime);
        $this->command->info("Database seeding completed in {$duration} seconds!");
        $this->command->info('');
        $this->command->info('Test Credentials:');
        $this->command->info('  Admin:    admin@ebilling.local / admin123');
        $this->command->info('  Operator: operator@ebilling.local / operator123');
        $this->command->info('  Customers: Cek table users (role = customer)');
    }
}
