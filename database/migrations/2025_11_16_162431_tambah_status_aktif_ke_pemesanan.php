<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum status untuk menambahkan 'aktif'
        DB::statement("ALTER TABLE pemesanan MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'dibayar', 'aktif', 'selesai', 'dibatalkan') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum semula
        DB::statement("ALTER TABLE pemesanan MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'dibayar', 'selesai', 'dibatalkan') DEFAULT 'pending'");
    }
};
