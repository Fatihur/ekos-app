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
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilik_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('nama_kos');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_kos', ['putra', 'putri', 'campur']);
            $table->enum('jenis_kamar', ['kamar_mandi_dalam', 'kamar_mandi_luar']);
            $table->decimal('harga', 10, 2);
            $table->integer('jumlah_kamar')->default(1);
            $table->integer('kamar_tersedia')->default(1);
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('peraturan')->nullable();
            $table->string('foto_utama')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};
