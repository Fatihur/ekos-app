<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kos';

    protected $fillable = [
        'pemilik_id',
        'nama_kos',
        'deskripsi',
        'jenis_kos',
        'jenis_kamar',
        'harga',
        'jumlah_kamar',
        'kamar_tersedia',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'latitude',
        'longitude',
        'peraturan',
        'foto_utama',
        'aktif',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'aktif' => 'boolean',
    ];

    public function pemilik()
    {
        return $this->belongsTo(Pengguna::class, 'pemilik_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_kos', 'kos_id', 'fasilitas_id');
    }

    public function foto()
    {
        return $this->hasMany(FotoKos::class, 'kos_id');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'kos_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'kos_id');
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class, 'kos_id');
    }

    public function getRatingRataRataAttribute()
    {
        return $this->ulasan()->avg('rating') ?? 0;
    }

    public function getJumlahUlasanAttribute()
    {
        return $this->ulasan()->count();
    }
}
