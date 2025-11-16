<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $fillable = [
        'nama_fasilitas',
        'ikon',
    ];

    public function kos()
    {
        return $this->belongsToMany(Kos::class, 'fasilitas_kos', 'fasilitas_id', 'kos_id');
    }
}
