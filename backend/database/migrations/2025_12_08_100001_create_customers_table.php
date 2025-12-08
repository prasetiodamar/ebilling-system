<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_number')->unique();
            $table->string('full_name');
            $table->enum('package_type', ['basic', 'standard', 'premium'])->default('standard');
            $table->decimal('monthly_fee', 10, 2);
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->enum('status', ['active', 'inactive', 'suspended', 'disconnected'])->default('active');
            $table->enum('payment_status', ['paid', 'pending', 'overdue'])->default('pending');
            $table->timestamp('last_payment_date')->nullable();
            $table->timestamp('next_billing_date')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('router_mac_address')->nullable();
            $table->string('installation_address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_number', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['payment_status']);
            $table->index(['package_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
