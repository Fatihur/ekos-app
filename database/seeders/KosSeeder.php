<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kos;
use App\Models\Pengguna;
use App\Models\Fasilitas;

class KosSeeder extends Seeder
{
    public function run(): void
    {
        $pemilik = Pengguna::where('peran', 'pemilik_kos')->first();

        if (!$pemilik) {
            return;
        }

        $kosList = [
            [
                'nama_kos' => 'Kos Harmoni Jakarta Pusat',
                'deskripsi' => 'Kos nyaman di pusat kota Jakarta dengan akses mudah ke berbagai tempat. Dekat stasiun, mall, dan pusat bisnis. Fasilitas lengkap dan aman.',
                'jenis_kos' => 'campur',
                'jenis_kamar' => 'kamar_mandi_dalam',
                'harga' => 1500000,
                'jumlah_kamar' => 15,
                'kamar_tersedia' => 8,
                'alamat' => 'Jl. Tanah Abang III No. 45',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '10160',
                'peraturan' => "- Dilarang membawa tamu menginap\n- Jam malam pukul 22.00\n- Dilarang merokok di dalam kamar\n- Bayar tepat waktu",
                'aktif' => true,
                'fasilitas' => [1, 2, 3, 5, 9, 13],
            ],
            [
                'nama_kos' => 'Kos Putri Melati Bandung',
                'deskripsi' => 'Kos khusus putri dengan keamanan 24 jam. Lingkungan bersih dan nyaman. Dekat dengan kampus dan pusat perbelanjaan.',
                'jenis_kos' => 'putri',
                'jenis_kamar' => 'kamar_mandi_dalam',
                'harga' => 1200000,
                'jumlah_kamar' => 20,
                'kamar_tersedia' => 5,
                'alamat' => 'Jl. Dago No. 123',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40135',
                'peraturan' => "- Khusus putri\n- Jam berkunjung tamu 08.00-20.00\n- Dilarang membuat keributan\n- Jaga kebersihan bersama",
                'aktif' => true,
                'fasilitas' => [1, 2, 3, 4, 5, 6, 9, 10],
            ],
            [
                'nama_kos' => 'Kos Putra Sejahtera Surabaya',
                'deskripsi' => 'Kos putra strategis dekat kampus ITS dan Unair. Fasilitas lengkap dengan harga terjangkau. Parkir luas dan aman.',
                'jenis_kos' => 'putra',
                'jenis_kamar' => 'kamar_mandi_luar',
                'harga' => 800000,
                'jumlah_kamar' => 25,
                'kamar_tersedia' => 12,
                'alamat' => 'Jl. Keputih No. 88',
                'kota' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'kode_pos' => '60111',
                'peraturan' => "- Khusus putra\n- Dilarang membawa senjata tajam\n- Jaga kebersihan kamar mandi bersama\n- Bayar sebelum tanggal 5",
                'aktif' => true,
                'fasilitas' => [1, 5, 9, 11, 13],
            ],
            [
                'nama_kos' => 'Kos Mawar Yogyakarta',
                'deskripsi' => 'Kos nyaman dekat UGM dan UNY. Suasana tenang cocok untuk belajar. Pemilik ramah dan responsif.',
                'jenis_kos' => 'campur',
                'jenis_kamar' => 'kamar_mandi_dalam',
                'harga' => 1000000,
                'jumlah_kamar' => 18,
                'kamar_tersedia' => 7,
                'alamat' => 'Jl. Kaliurang KM 5',
                'kota' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'kode_pos' => '55281',
                'peraturan' => "- Jaga ketenangan\n- Dilarang pesta di kamar\n- Tamu wajib lapor\n- Listrik dan air sudah termasuk",
                'aktif' => true,
                'fasilitas' => [1, 2, 3, 5, 6, 9, 13, 15],
            ],
            [
                'nama_kos' => 'Kos Anggrek Semarang',
                'deskripsi' => 'Kos bersih dan nyaman di pusat kota Semarang. Dekat dengan kampus UNDIP dan pusat bisnis. Akses mudah ke mana-mana.',
                'jenis_kos' => 'putri',
                'jenis_kamar' => 'kamar_mandi_dalam',
                'harga' => 950000,
                'jumlah_kamar' => 12,
                'kamar_tersedia' => 3,
                'alamat' => 'Jl. Pandanaran No. 56',
                'kota' => 'Semarang',
                'provinsi' => 'Jawa Tengah',
                'kode_pos' => '50134',
                'peraturan' => "- Khusus putri\n- Jam malam 22.00\n- Dilarang merokok\n- Jaga kebersihan",
                'aktif' => true,
                'fasilitas' => [1, 2, 3, 5, 9, 10, 13],
            ],
        ];

        foreach ($kosList as $kosData) {
            $fasilitas = $kosData['fasilitas'];
            unset($kosData['fasilitas']);
            
            $kosData['pemilik_id'] = $pemilik->id;
            
            $kos = Kos::create($kosData);
            
            // Attach fasilitas
            $kos->fasilitas()->attach($fasilitas);
        }
    }
}
