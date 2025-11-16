<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\Support\Facades\Auth;

class DetailKosController extends Controller
{
    public function show($id)
    {
        $kos = Kos::with(['pemilik', 'fasilitas', 'foto', 'ulasan.pengguna'])
            ->where('aktif', true)
            ->findOrFail($id);

        $isBookmarked = false;
        if (Auth::check()) {
            $isBookmarked = $kos->bookmark()->where('pengguna_id', Auth::id())->exists();
        }

        $kosLainnya = Kos::where('pemilik_id', $kos->pemilik_id)
            ->where('id', '!=', $kos->id)
            ->where('aktif', true)
            ->limit(3)
            ->get();

        return view('detail-kos', compact('kos', 'isBookmarked', 'kosLainnya'));
    }
}
