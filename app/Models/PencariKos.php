<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencariKos extends Model
{
    use HasFactory;

    protected $table = 'pencari_kos';

    protected $fillable = [
        'pengguna_id',
        'nama_lengkap',
        'no_telpon',
        'foto_profil',
        'alamat',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'pencari_id', 'pengguna_id');
    }
}
