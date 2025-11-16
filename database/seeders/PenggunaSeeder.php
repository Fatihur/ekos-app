<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::create([
            'nama' => 'Administrator',
            'email' => 'admin@ekos.com',
            'telepon' => '081234567890',
            'password' => Hash::make('admin123'),
            'peran' => 'admin',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        Pengguna::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@ekos.com',
            'telepon' => '081234567891',
            'password' => Hash::make('pemilik123'),
            'peran' => 'pemilik_kos',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'nomor_rekening' => '1234567890',
            'nama_bank' => 'BCA',
            'nama_pemilik_rekening' => 'Budi Santoso',
            'whatsapp' => '081234567891',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        Pengguna::create([
            'nama' => 'Siti Nur Azizah',
            'email' => 'siti@ekos.com',
            'telepon' => '081234567892',
            'password' => Hash::make('pencari123'),
            'peran' => 'pencari_kos',
            'alamat' => 'Jl. Gatot Subroto No. 456, Bandung',
            'aktif' => true,
            'email_verified_at' => now(),
        ]);
    }
}
