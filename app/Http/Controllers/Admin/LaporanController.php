<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Pemesanan;
use App\Models\Pengguna;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('Y-m'));
        
        // Statistik Umum
        $totalKos = Kos::count();
        $totalPengguna = Pengguna::count();
        $totalPemesanan = Pemesanan::whereMonth('created_at', date('m', strtotime($bulan)))
            ->whereYear('created_at', date('Y', strtotime($bulan)))
            ->count();
        $totalPendapatan = Pembayaran::where('status', 'berhasil')
            ->whereMonth('created_at', date('m', strtotime($bulan)))
            ->whereYear('created_at', date('Y', strtotime($bulan)))
            ->sum('jumlah');

        // Pemesanan per Status
        $pemesananPerStatus = Pemesanan::select('status', DB::raw('count(*) as total'))
            ->whereMonth('created_at', date('m', strtotime($bulan)))
            ->whereYear('created_at', date('Y', strtotime($bulan)))
            ->groupBy('status')
            ->get();

        // Kos Terpopuler
        $kosPopuler = Kos::withCount('pemesanan')
            ->orderBy('pemesanan_count', 'desc')
            ->limit(10)
            ->get();

        // Pemilik Kos Teraktif
        $pemilikAktif = Pengguna::where('peran', 'pemilik_kos')
            ->withCount('kos')
            ->orderBy('kos_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.laporan.index', compact(
            'totalKos',
            'totalPengguna',
            'totalPemesanan',
            'totalPendapatan',
            'pemesananPerStatus',
            'kosPopuler',
            'pemilikAktif',
            'bulan'
        ));
    }
}
