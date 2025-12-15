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
    Schema::create('pelanggan', function (Blueprint $table) {
        $table->id('id_pelanggan');
        $table->string('kode_pelanggan', 50)->unique();
        $table->string('nama', 100);
        $table->text('alamat');
        $table->string('telepon', 20);
        $table->string('email', 100)->unique();
        $table->enum('status', ['aktif', 'suspend', 'nonaktif'])->default('aktif');
        $table->foreignId('paket_id')->nullable()->constrained('paket')->onDelete('set null');
        $table->date('tanggal_berlangganan');

        // FTTH Infrastructure
        $table->foreignId('odp_id')->nullable()->constrained('ftth_odp')->onDelete('set null');
        $table->string('odp_port', 20)->nullable();
        $table->string('ont_sn', 50)->nullable();
        $table->string('ont_mac', 17)->nullable();

        // PPPoE Credentials
        $table->string('pppoe_username', 100)->nullable()->unique();
        $table->string('pppoe_password', 100)->nullable();

        // Billing
        $table->decimal('tagihan_bulanan', 10, 2)->default(0);
        $table->integer('tanggal_jatuh_tempo')->default(5);

        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->index('kode_pelanggan');
        $table->index('status');
        $table->index('paket_id');
        $table->index('odp_id');
        $table->index('pppoe_username');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
