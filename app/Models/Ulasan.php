<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ulasan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ulasan';

    protected $fillable = [
        'kos_id',
        'pengguna_id',
        'pemesanan_id',
        'rating',
        'komentar',
        'disetujui',
    ];

    protected $casts = [
        'disetujui' => 'boolean',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}
