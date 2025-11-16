<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $pemesanan = Pemesanan::findOrFail($request->pemesanan_id);

        // Cek apakah pemesanan milik user yang login
        if ($pemesanan->pencari_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memberikan ulasan ini');
        }

        // Cek apakah pemesanan sudah selesai
        if ($pemesanan->status !== 'selesai') {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan ulasan setelah pemesanan selesai');
        }

        // Cek apakah sudah pernah memberikan ulasan
        $existingUlasan = Ulasan::where('pemesanan_id', $pemesanan->id)->first();
        if ($existingUlasan) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pemesanan ini');
        }

        Ulasan::create([
            'kos_id' => $pemesanan->kos_id,
            'pemesanan_id' => $pemesanan->id,
            'pengguna_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $ulasan = Ulasan::findOrFail($id);

        // Cek apakah ulasan milik user yang login
        if ($ulasan->pengguna_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah ulasan ini');
        }

        $ulasan->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);

        // Cek apakah ulasan milik user yang login
        if ($ulasan->pengguna_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus ulasan ini');
        }

        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus');
    }
}
