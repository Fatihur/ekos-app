<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pemesanan_id',
        'jumlah',
        'bukti_pembayaran',
        'status',
        'catatan',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_verifikasi' => 'datetime',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}
