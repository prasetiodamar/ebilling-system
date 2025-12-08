<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('payment_number')->unique();
            $table->enum('payment_method', ['bank_transfer', 'credit_card', 'debit_card', 'e_wallet', 'cash', 'check'])->default('bank_transfer');
            $table->string('payment_gateway')->nullable();
            $table->string('gateway_reference_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamp('payment_date')->nullable();
            $table->string('description')->nullable();
            $table->text('notes')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['payment_number']);
            $table->index(['customer_id', 'status']);
            $table->index(['invoice_id', 'status']);
            $table->index(['payment_gateway']);
            $table->index(['payment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
