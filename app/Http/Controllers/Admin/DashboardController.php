<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Kos;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdmin = Pengguna::where('peran', 'admin')->count();
        $totalPemilikKos = Pengguna::where('peran', 'pemilik_kos')->count();
        $totalPencariKos = Pengguna::where('peran', 'pencari_kos')->count();
        $totalKos = Kos::count();
        $kosAktif = Kos::where('aktif', true)->count();
        $totalPemesanan = Pemesanan::count();
        $pemesananPending = Pemesanan::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalAdmin',
            'totalPemilikKos',
            'totalPencariKos',
            'totalKos',
            'kosAktif',
            'totalPemesanan',
            'pemesananPending'
        ));
    }
}
