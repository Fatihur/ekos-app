<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bookmark;
use App\Models\Pengguna;
use App\Models\Kos;

class BookmarkSeeder extends Seeder
{
    public function run(): void
    {
        // Get pencari kos users
        $pencariKos = Pengguna::where('peran', 'pencari_kos')->get();
        
        // Get some kos
        $kosList = Kos::limit(10)->get();
        
        if ($pencariKos->count() > 0 && $kosList->count() > 0) {
            foreach ($pencariKos as $pencari) {
                // Each pencari bookmarks 1-3 random kos (or less if not enough kos available)
                $maxBookmarks = min(3, $kosList->count());
                $numBookmarks = rand(1, $maxBookmarks);
                
                if ($numBookmarks > 0) {
                    $randomKos = $kosList->random($numBookmarks);
                    
                    foreach ($randomKos as $kos) {
                        // Check if bookmark already exists
                        $exists = Bookmark::where('pengguna_id', $pencari->id)
                            ->where('kos_id', $kos->id)
                            ->exists();
                        
                        if (!$exists) {
                            Bookmark::create([
                                'pengguna_id' => $pencari->id,
                                'kos_id' => $kos->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
