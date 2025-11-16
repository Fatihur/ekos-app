<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pemesanan;
use App\Models\Kos;
use App\Models\Pengguna;
use Carbon\Carbon;

class PemesananSeeder extends Seeder
{
    public function run(): void
    {
        $pencari = Pengguna::where('peran', 'pencari_kos')->first();
        $kosList = Kos::all();

        if (!$pencari || $kosList->isEmpty()) {
            return;
        }

        $statusList = ['pending', 'disetujui', 'ditolak', 'dibayar', 'selesai'];
        $satuanDurasi = ['bulan', 'tahun'];

        foreach ($kosList as $index => $kos) {
            // Buat 2-3 pemesanan per kos
            $jumlahPemesanan = rand(2, 3);
            
            for ($i = 0; $i < $jumlahPemesanan; $i++) {
                $durasi = rand(1, 6); // Maksimal 6 bulan/tahun
                $satuan = 'bulan'; // Hanya bulan untuk menghindari nilai terlalu besar
                $totalHarga = $kos->harga * $durasi;
                
                $status = $statusList[array_rand($statusList)];
                $tanggalMasuk = Carbon::now()->addDays(rand(1, 60));
                
                $pemesanan = Pemesanan::create([
                    'kos_id' => $kos->id,
                    'pencari_id' => $pencari->id,
                    'kode_pemesanan' => 'KOS-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                    'tanggal_masuk' => $tanggalMasuk,
                    'durasi_sewa' => $durasi,
                    'satuan_durasi' => $satuan,
                    'total_harga' => $totalHarga,
                    'status' => $status,
                    'catatan' => $i == 0 ? 'Mohon kamar yang tenang' : null,
                    'tanggal_disetujui' => in_array($status, ['disetujui', 'dibayar', 'selesai']) ? Carbon::now()->subDays(rand(1, 10)) : null,
                    'tanggal_dibayar' => in_array($status, ['dibayar', 'selesai']) ? Carbon::now()->subDays(rand(1, 5)) : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
