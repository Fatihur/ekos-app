<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'password',
        'peran',
        'foto_profil',
        'alamat',
        'nomor_rekening',
        'nama_bank',
        'nama_pemilik_rekening',
        'whatsapp',
        'aktif',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'aktif' => 'boolean',
    ];

    public function kos()
    {
        return $this->hasMany(Kos::class, 'pemilik_id');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'pencari_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pengguna_id');
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class, 'pengguna_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'pengguna_id');
    }

    public function isAdmin()
    {
        return $this->peran === 'admin';
    }

    public function isPemilikKos()
    {
        return $this->peran === 'pemilik_kos';
    }

    public function isPencariKos()
    {
        return $this->peran === 'pencari_kos';
    }
}
