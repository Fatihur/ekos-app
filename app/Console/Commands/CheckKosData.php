<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kos;

class CheckKosData extends Command
{
    protected $signature = 'check:kos';
    protected $description = 'Check kos data and photos';

    public function handle()
    {
        $kos = Kos::with('foto')->get();
        
        $this->info("Total Kos: " . $kos->count());
        
        foreach ($kos as $k) {
            $this->line("---");
            $this->info("Kos: {$k->nama_kos}");
            $this->line("Foto Utama: " . ($k->foto_utama ?? 'NULL'));
            $this->line("Jumlah Foto Galeri: " . $k->foto->count());
            
            if ($k->foto->count() > 0) {
                foreach ($k->foto as $foto) {
                    $path = storage_path('app/public/' . $foto->foto);
                    $exists = file_exists($path) ? 'EXISTS' : 'NOT FOUND';
                    $this->line("  - {$foto->foto} ({$exists})");
                }
            }
        }
    }
}
