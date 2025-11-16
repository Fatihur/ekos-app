<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kosTerbaru = Kos::where('aktif', true)
            ->with(['pemilik', 'foto', 'fasilitas'])
            ->withCount('ulasan')
            ->latest()
            ->take(6)
            ->get();

        $kosPopuler = Kos::where('aktif', true)
            ->with(['pemilik', 'foto', 'fasilitas'])
            ->withCount('pemesanan')
            ->orderBy('pemesanan_count', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('kosTerbaru', 'kosPopuler'));
    }

    public function pencarian(Request $request)
    {
        $query = Kos::where('aktif', true)->with(['pemilik', 'foto', 'fasilitas']);

        if ($request->filled('kata_kunci')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kos', 'like', '%' . $request->kata_kunci . '%')
                  ->orWhere('alamat', 'like', '%' . $request->kata_kunci . '%')
                  ->orWhere('kota', 'like', '%' . $request->kata_kunci . '%');
            });
        }

        if ($request->filled('jenis_kos')) {
            $query->where('jenis_kos', $request->jenis_kos);
        }

        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }

        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        $kosList = $query->paginate(12);

        return view('pencarian', compact('kosList'));
    }
}
