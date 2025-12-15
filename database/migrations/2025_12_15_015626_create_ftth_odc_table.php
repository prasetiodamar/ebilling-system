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
    Schema::create('ftth_odc', function (Blueprint $table) {
        $table->id();
        $table->foreignId('olt_id')->constrained('ftth_olt')->onDelete('restrict');
        $table->string('nama_odc', 100);
        $table->string('olt_port', 50)->nullable();
        $table->string('lokasi', 255);
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->integer('jumlah_port')->default(0);
        $table->integer('port_tersedia')->default(0);
        $table->string('splitter_ratio', 20)->nullable();
        $table->enum('status', ['aktif', 'nonaktif', 'maintenance'])->default('aktif');
        $table->string('jenis_kabel', 50)->nullable();
        $table->decimal('panjang_kabel', 8, 2)->nullable()->comment('dalam meter');
        $table->string('area_coverage', 255)->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->index('olt_id');
        $table->index('nama_odc');
        $table->index('status');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ftth_odc');
    }
};
