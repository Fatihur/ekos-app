<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use Illuminate\Http\Request;

class ManajemenKosController extends Controller
{
    public function index(Request $request)
    {
        $query = Kos::with(['pemilik', 'pemesanan']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kos', 'like', '%' . $request->search . '%')
                  ->orWhere('kota', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pemilik', function($q2) use ($request) {
                      $q2->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('jenis_kos')) {
            $query->where('jenis_kos', $request->jenis_kos);
        }

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $kosList = $query->latest()->paginate(15);

        return view('admin.kos.index', compact('kosList'));
    }

    public function show($id)
    {
        $kos = Kos::with(['pemilik', 'fasilitas', 'foto', 'pemesanan.pengguna'])
            ->findOrFail($id);

        return view('admin.kos.show', compact('kos'));
    }

    public function toggleAktif($id)
    {
        $kos = Kos::findOrFail($id);
        $kos->update(['aktif' => !$kos->aktif]);

        return back()->with('success', 'Status kos berhasil diubah');
    }
}
