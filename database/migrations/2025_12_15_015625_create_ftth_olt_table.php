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
    Schema::create('ftth_olt', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pop_id')->constrained('ftth_pop')->onDelete('restrict');
        $table->string('nama_olt', 100);
        $table->string('ip_address', 45)->nullable();
        $table->string('lokasi', 255);
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->string('merk', 50)->nullable();
        $table->string('model', 50)->nullable();
        $table->integer('jumlah_port_pon')->default(0);
        $table->integer('port_tersedia')->default(0);
        $table->enum('status', ['aktif', 'nonaktif', 'maintenance'])->default('aktif');
        $table->string('snmp_community', 50)->nullable();
        $table->string('snmp_version', 10)->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->index('pop_id');
        $table->index('nama_olt');
        $table->index('status');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ftth_olt');
    }
};
