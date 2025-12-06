<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemilikKos extends Model
{
    use HasFactory;

    protected $table = 'pemilik_kos';

    protected $fillable = [
        'pengguna_id',
        'nama_lengkap',
        'no_telpon',
        'foto_profil',
        'alamat',
        'whatsapp',
        'nomor_rekening',
        'nama_bank',
        'nama_pemilik_rekening',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function kos()
    {
        return $this->hasMany(Kos::class, 'pemilik_id', 'pengguna_id');
    }
}
