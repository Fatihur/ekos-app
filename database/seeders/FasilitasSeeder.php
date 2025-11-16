<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitas = [
            ['nama_fasilitas' => 'WiFi', 'ikon' => 'fa-wifi'],
            ['nama_fasilitas' => 'AC', 'ikon' => 'fa-snowflake'],
            ['nama_fasilitas' => 'Kamar Mandi Dalam', 'ikon' => 'fa-bath'],
            ['nama_fasilitas' => 'Kasur', 'ikon' => 'fa-bed'],
            ['nama_fasilitas' => 'Lemari', 'ikon' => 'fa-door-closed'],
            ['nama_fasilitas' => 'Meja Belajar', 'ikon' => 'fa-desk'],
            ['nama_fasilitas' => 'Kursi', 'ikon' => 'fa-chair'],
            ['nama_fasilitas' => 'Dapur Bersama', 'ikon' => 'fa-utensils'],
            ['nama_fasilitas' => 'Laundry', 'ikon' => 'fa-tshirt'],
            ['nama_fasilitas' => 'Parkir Motor', 'ikon' => 'fa-motorcycle'],
            ['nama_fasilitas' => 'Parkir Mobil', 'ikon' => 'fa-car'],
            ['nama_fasilitas' => 'Keamanan 24 Jam', 'ikon' => 'fa-shield-alt'],
            ['nama_fasilitas' => 'CCTV', 'ikon' => 'fa-video'],
            ['nama_fasilitas' => 'Listrik', 'ikon' => 'fa-bolt'],
            ['nama_fasilitas' => 'Air', 'ikon' => 'fa-tint'],
            ['nama_fasilitas' => 'Televisi', 'ikon' => 'fa-tv'],
            ['nama_fasilitas' => 'Kulkas', 'ikon' => 'fa-ice-cream'],
            ['nama_fasilitas' => 'Ruang Tamu', 'ikon' => 'fa-couch'],
            ['nama_fasilitas' => 'Jendela', 'ikon' => 'fa-window-maximize'],
            ['nama_fasilitas' => 'Ventilasi', 'ikon' => 'fa-fan'],
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::create($item);
        }
    }
}
