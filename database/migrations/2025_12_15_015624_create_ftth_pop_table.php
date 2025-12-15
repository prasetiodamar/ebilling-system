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
    Schema::create('ftth_pop', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pop', 100);
        $table->string('lokasi', 255);
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->string('pic_nama', 100)->nullable();
        $table->string('pic_telepon', 20)->nullable();
        $table->text('alamat_lengkap')->nullable();
        $table->enum('status', ['aktif', 'nonaktif', 'maintenance'])->default('aktif');
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->index('nama_pop');
        $table->index('status');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ftth_pop');
    }
};
