<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemesanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemesanan';

    protected $fillable = [
        'kos_id',
        'pencari_id',
        'kode_pemesanan',
        'tanggal_masuk',
        'durasi_sewa',
        'satuan_durasi',
        'total_harga',
        'status',
        'catatan',
        'alasan_penolakan',
        'tanggal_disetujui',
        'tanggal_dibayar',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'total_harga' => 'decimal:2',
        'tanggal_disetujui' => 'datetime',
        'tanggal_dibayar' => 'datetime',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    public function pencari()
    {
        return $this->belongsTo(Pengguna::class, 'pencari_id');
    }

    // Alias untuk konsistensi
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pencari_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pemesanan_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'pemesanan_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pemesanan) {
            if (empty($pemesanan->kode_pemesanan)) {
                $pemesanan->kode_pemesanan = 'KOS-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }
}
