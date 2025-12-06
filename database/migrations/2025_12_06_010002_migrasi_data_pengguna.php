<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrasi data pemilik kos
        $pemilikKos = DB::table('pengguna')
            ->where('peran', 'pemilik_kos')
            ->get();

        foreach ($pemilikKos as $pemilik) {
            DB::table('pemilik_kos')->insert([
                'pengguna_id' => $pemilik->id,
                'nama_lengkap' => $pemilik->nama,
                'no_telpon' => $pemilik->telepon,
                'foto_profil' => $pemilik->foto_profil,
                'alamat' => $pemilik->alamat,
                'whatsapp' => $pemilik->whatsapp,
                'nomor_rekening' => $pemilik->nomor_rekening,
                'nama_bank' => $pemilik->nama_bank,
                'nama_pemilik_rekening' => $pemilik->nama_pemilik_rekening,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Migrasi data pencari kos
        $pencariKos = DB::table('pengguna')
            ->where('peran', 'pencari_kos')
            ->get();

        foreach ($pencariKos as $pencari) {
            DB::table('pencari_kos')->insert([
                'pengguna_id' => $pencari->id,
                'nama_lengkap' => $pencari->nama,
                'no_telpon' => $pencari->telepon,
                'foto_profil' => $pencari->foto_profil,
                'alamat' => $pencari->alamat,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus kolom yang sudah dipindahkan dari tabel pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['telepon', 'foto_profil', 'alamat', 'nomor_rekening', 'nama_bank', 'nama_pemilik_rekening', 'whatsapp']);
        });
    }

    public function down(): void
    {
        // Kembalikan kolom ke tabel pengguna
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('telepon', 20)->nullable()->after('peran');
            $table->string('foto_profil')->nullable()->after('telepon');
            $table->text('alamat')->nullable()->after('foto_profil');
            $table->string('nomor_rekening')->nullable()->after('alamat');
            $table->string('nama_bank')->nullable()->after('nomor_rekening');
            $table->string('nama_pemilik_rekening')->nullable()->after('nama_bank');
            $table->string('whatsapp', 20)->nullable()->after('nama_pemilik_rekening');
        });

        // Kembalikan data pemilik kos
        $pemilikKosData = DB::table('pemilik_kos')->get();
        foreach ($pemilikKosData as $data) {
            DB::table('pengguna')
                ->where('id', $data->pengguna_id)
                ->update([
                    'telepon' => $data->no_telpon,
                    'foto_profil' => $data->foto_profil,
                    'alamat' => $data->alamat,
                    'nomor_rekening' => $data->nomor_rekening,
                    'nama_bank' => $data->nama_bank,
                    'nama_pemilik_rekening' => $data->nama_pemilik_rekening,
                    'whatsapp' => $data->whatsapp,
                ]);
        }

        // Kembalikan data pencari kos
        $pencariKosData = DB::table('pencari_kos')->get();
        foreach ($pencariKosData as $data) {
            DB::table('pengguna')
                ->where('id', $data->pengguna_id)
                ->update([
                    'telepon' => $data->no_telpon,
                    'foto_profil' => $data->foto_profil,
                    'alamat' => $data->alamat,
                ]);
        }
    }
};
