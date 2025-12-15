<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('monitoring_pppoe', function (Blueprint $table) {
        $table->id('id_monitoring');
        $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
        $table->string('mikrotik_username', 100);
        $table->string('session_id', 100)->nullable();
        $table->string('ip_address', 45)->nullable();
        $table->string('mac_address', 17)->nullable();
        $table->string('interface', 50)->nullable();
        $table->string('caller_id', 50)->nullable();
        $table->string('uptime', 50)->nullable();
        $table->bigInteger('bytes_in')->default(0);
        $table->bigInteger('bytes_out')->default(0);
        $table->bigInteger('packets_in')->default(0);
        $table->bigInteger('packets_out')->default(0);
        $table->timestamp('session_start')->nullable();
        $table->timestamp('session_end')->nullable();
        $table->string('disconnect_reason', 100)->nullable();
        $table->enum('status', ['online', 'offline', 'disconnected'])->default('offline');
        $table->timestamps();

        $table->index('id_pelanggan');
        $table->index('mikrotik_username');
        $table->index('status');
        $table->index('session_start');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_pppoe');
    }
};
