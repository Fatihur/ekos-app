<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class ManajemenPemesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['kos', 'pencari', 'kos.pemilik']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_pemesanan', 'like', "%{$search}%")
                    ->orWhereHas('pencari', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kos', function ($q) use ($search) {
                        $q->where('nama_kos', 'like', "%{$search}%");
                    });
            });
        }

        $pemesanan = $query->latest()->paginate(15);

        return view('admin.pemesanan.index', compact('pemesanan'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['kos', 'pencari', 'kos.pemilik', 'pembayaran', 'ulasan'])
            ->findOrFail($id);

        return view('admin.pemesanan.show', compact('pemesanan'));
    }
}
