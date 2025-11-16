<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ulasan;
use App\Models\Pemesanan;
use App\Models\Pengguna;
use Carbon\Carbon;

class UlasanSeeder extends Seeder
{
    public function run(): void
    {
        $pencari = Pengguna::where('peran', 'pencari_kos')->first();
        
        if (!$pencari) {
            return;
        }

        // Ambil pemesanan yang sudah selesai atau dibayar
        $pemesananList = Pemesanan::whereIn('status', ['dibayar', 'selesai'])
            ->where('pencari_id', $pencari->id)
            ->get();

        $komentarPositif = [
            'Kos sangat nyaman dan bersih. Pemilik ramah dan responsif. Recommended!',
            'Lokasi strategis, dekat dengan kampus. Fasilitas lengkap dan harga terjangkau.',
            'Kamar luas dan bersih. Lingkungan aman dan tenang. Cocok untuk mahasiswa.',
            'Pelayanan pemilik sangat baik. Kos terawat dengan baik. Puas tinggal di sini.',
            'Fasilitas lengkap, WiFi cepat, kamar mandi bersih. Sangat memuaskan!',
        ];

        $komentarNetral = [
            'Kos cukup bagus, tapi kadang WiFi agak lambat. Overall oke lah.',
            'Lokasi strategis tapi parkir agak sempit. Sisanya bagus.',
            'Kamar nyaman, tapi kadang air panas tidak stabil. Masih oke sih.',
        ];

        $komentarNegatif = [
            'Kamar kurang bersih dan WiFi sering mati. Perlu perbaikan.',
            'Harga cukup mahal untuk fasilitas yang didapat. Kurang worth it.',
        ];

        foreach ($pemesananList as $pemesanan) {
            // 70% chance untuk membuat ulasan
            if (rand(1, 10) <= 7) {
                $rating = rand(3, 5); // Rating antara 3-5
                
                if ($rating == 5) {
                    $komentar = $komentarPositif[array_rand($komentarPositif)];
                } elseif ($rating == 4) {
                    $komentar = rand(1, 2) == 1 ? $komentarPositif[array_rand($komentarPositif)] : $komentarNetral[array_rand($komentarNetral)];
                } else {
                    $komentar = $komentarNetral[array_rand($komentarNetral)];
                }

                Ulasan::create([
                    'kos_id' => $pemesanan->kos_id,
                    'pengguna_id' => $pencari->id,
                    'pemesanan_id' => $pemesanan->id,
                    'rating' => $rating,
                    'komentar' => $komentar,
                    'created_at' => Carbon::now()->subDays(rand(1, 20)),
                ]);
            }
        }
    }
}
