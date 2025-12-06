<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;

class Pengguna extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran',
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

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id');
    }

    public function notifikasiBelumDibaca()
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id')->where('dibaca', false);
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

    public function pemilikKos()
    {
        return $this->hasOne(PemilikKos::class, 'pengguna_id');
    }

    public function pencariKos()
    {
        return $this->hasOne(PencariKos::class, 'pengguna_id');
    }

    // Accessor untuk backward compatibility
    public function getTeleponAttribute()
    {
        if ($this->isPemilikKos()) {
            return $this->pemilikKos?->no_telpon;
        }
        return $this->pencariKos?->no_telpon;
    }

    public function getFotoProfilAttribute()
    {
        if ($this->isPemilikKos()) {
            return $this->pemilikKos?->foto_profil;
        }
        return $this->pencariKos?->foto_profil;
    }

    public function getAlamatAttribute()
    {
        if ($this->isPemilikKos()) {
            return $this->pemilikKos?->alamat;
        }
        return $this->pencariKos?->alamat;
    }

    public function getNomorRekeningAttribute()
    {
        return $this->pemilikKos?->nomor_rekening;
    }

    public function getNamaBankAttribute()
    {
        return $this->pemilikKos?->nama_bank;
    }

    public function getNamaPemilikRekeningAttribute()
    {
        return $this->pemilikKos?->nama_pemilik_rekening;
    }

    public function getWhatsappAttribute()
    {
        return $this->pemilikKos?->whatsapp;
    }
}
