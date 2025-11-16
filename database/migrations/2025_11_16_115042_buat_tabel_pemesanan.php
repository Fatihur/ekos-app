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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
            $table->foreignId('pencari_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('kode_pemesanan')->unique();
            $table->date('tanggal_masuk');
            $table->integer('durasi_sewa');
            $table->enum('satuan_durasi', ['hari', 'bulan', 'tahun'])->default('bulan');
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dibayar', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamp('tanggal_dibayar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
