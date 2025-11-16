<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kos;
use App\Models\Pengguna;

class TestKosCreate extends Command
{
    protected $signature = 'test:kos';
    protected $description = 'Test creating kos';

    public function handle()
    {
        $pemilik = Pengguna::where('peran', 'pemilik_kos')->first();
        
        if (!$pemilik) {
            $this->error('No pemilik found');
            return;
        }

        try {
            $kos = Kos::create([
                'pemilik_id' => $pemilik->id,
                'nama_kos' => 'Test Kos Jakarta',
                'jenis_kos' => 'campur',
                'jenis_kamar' => 'bulan',
                'harga' => 1500000,
                'deskripsi' => 'Test description',
                'alamat' => 'Jl. Test No. 123',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'jumlah_kamar' => 10,
                'kamar_tersedia' => 5,
                'aktif' => true,
            ]);
            
            $this->info("Kos created successfully! ID: {$kos->id}");
            $this->info("jenis_kamar: {$kos->jenis_kamar}");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
