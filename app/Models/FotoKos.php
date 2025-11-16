<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoKos extends Model
{
    use HasFactory;

    protected $table = 'foto_kos';

    protected $fillable = [
        'kos_id',
        'foto',
        'is_utama',
        'urutan',
    ];

    protected $casts = [
        'is_utama' => 'boolean',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }
}
