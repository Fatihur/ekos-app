<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'pengguna_id',
        'judul',
        'pesan',
        'tipe',
        'link',
        'dibaca',
        'dibaca_pada',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function markAsRead()
    {
        $this->update([
            'dibaca' => true,
            'dibaca_pada' => now(),
        ]);
    }

    public static function kirim($penggunaId, $judul, $pesan, $tipe = 'info', $link = null)
    {
        return self::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
            'link' => $link,
        ]);
    }
}
