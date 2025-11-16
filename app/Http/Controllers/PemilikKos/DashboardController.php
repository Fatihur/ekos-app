<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pemilikId = Auth::id();
        
        $totalKos = Kos::where('pemilik_id', $pemilikId)->count();
        $kosAktif = Kos::where('pemilik_id', $pemilikId)->where('aktif', true)->count();
        
        $totalPemesanan = Pemesanan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->count();
        
        $pemesananPending = Pemesanan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->where('status', 'pending')->count();

        $kosList = Kos::where('pemilik_id', $pemilikId)
            ->withCount('pemesanan')
            ->latest()
            ->take(5)
            ->get();

        $pemesananTerbaru = Pemesanan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })
            ->with(['kos', 'pencari'])
            ->latest()
            ->take(5)
            ->get();

        return view('pemilik.dashboard', compact(
            'totalKos',
            'kosAktif',
            'totalPemesanan',
            'pemesananPending',
            'kosList',
            'pemesananTerbaru'
        ));
    }
}
