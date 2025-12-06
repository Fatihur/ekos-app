<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\PemilikKos;
use App\Models\PencariKos;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = Pengguna::create([
            'nama' => 'Administrator',
            'email' => 'admin@ekos.com',
            'password' => Hash::make('password'),
            'peran' => 'admin',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        // Pemilik Kos 1
        $pemilik1 = Pengguna::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@ekos.com',
            'password' => Hash::make('password'),
            'peran' => 'pemilik_kos',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        PemilikKos::create([
            'pengguna_id' => $pemilik1->id,
            'nama_lengkap' => 'Budi Santoso',
            'no_telpon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'whatsapp' => '6281234567890',
            'nomor_rekening' => '1234567890',
            'nama_bank' => 'BCA',
            'nama_pemilik_rekening' => 'Budi Santoso',
        ]);

        // Pemilik Kos 2
        $pemilik2 = Pengguna::create([
            'nama' => 'Siti Rahayu',
            'email' => 'siti@ekos.com',
            'password' => Hash::make('password'),
            'peran' => 'pemilik_kos',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        PemilikKos::create([
            'pengguna_id' => $pemilik2->id,
            'nama_lengkap' => 'Siti Rahayu',
            'no_telpon' => '082345678901',
            'alamat' => 'Jl. Sudirman No. 25, Bandung',
            'whatsapp' => '6282345678901',
            'nomor_rekening' => '0987654321',
            'nama_bank' => 'Mandiri',
            'nama_pemilik_rekening' => 'Siti Rahayu',
        ]);

        // Pencari Kos 1
        $pencari1 = Pengguna::create([
            'nama' => 'Andi Pratama',
            'email' => 'andi@ekos.com',
            'password' => Hash::make('password'),
            'peran' => 'pencari_kos',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        PencariKos::create([
            'pengguna_id' => $pencari1->id,
            'nama_lengkap' => 'Andi Pratama',
            'no_telpon' => '083456789012',
            'alamat' => 'Jl. Pahlawan No. 5, Surabaya',
        ]);

        // Pencari Kos 2
        $pencari2 = Pengguna::create([
            'nama' => 'Dewi Lestari',
            'email' => 'dewi@ekos.com',
            'password' => Hash::make('password'),
            'peran' => 'pencari_kos',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        PencariKos::create([
            'pengguna_id' => $pencari2->id,
            'nama_lengkap' => 'Dewi Lestari',
            'no_telpon' => '084567890123',
            'alamat' => 'Jl. Diponegoro No. 15, Yogyakarta',
        ]);

        // Pencari Kos 3
        $pencari3 = Pengguna::create([
            'nama' => 'Rizki Hidayat',
            'email' => 'rizki@ekos.com',
            'password' => Hash::make('password'),
            'peran' => 'pencari_kos',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        PencariKos::create([
            'pengguna_id' => $pencari3->id,
            'nama_lengkap' => 'Rizki Hidayat',
            'no_telpon' => '085678901234',
            'alamat' => 'Jl. Ahmad Yani No. 20, Semarang',
        ]);
    }
}
