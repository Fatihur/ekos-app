<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kos;
use App\Models\FotoKos;
use Illuminate\Support\Facades\Storage;

class AssignDummyPhotos extends Command
{
    protected $signature = 'kos:assign-photos';
    protected $description = 'Assign existing photos to kos';

    public function handle()
    {
        // Get existing photos in storage
        $files = Storage::disk('public')->files('kos');
        
        if (empty($files)) {
            $this->error('No photos found in storage/app/public/kos');
            $this->info('Please upload photos via the web interface first.');
            return;
        }
        
        $this->info("Found " . count($files) . " photos");
        
        $kos = Kos::all();
        
        foreach ($kos as $k) {
            // Assign first photo as main photo
            if (count($files) > 0) {
                $k->foto_utama = $files[0];
                $k->save();
                $this->info("Assigned foto_utama to: {$k->nama_kos}");
                
                // Create gallery photos
                for ($i = 0; $i < min(3, count($files)); $i++) {
                    FotoKos::create([
                        'kos_id' => $k->id,
                        'foto' => $files[$i],
                        'is_utama' => $i === 0,
                        'urutan' => $i + 1,
                    ]);
                }
                
                $this->info("Created {$i} gallery photos for: {$k->nama_kos}");
            }
        }
        
        $this->info('Photos assigned successfully!');
        $this->info('Run: php artisan check:kos to verify');
    }
}
