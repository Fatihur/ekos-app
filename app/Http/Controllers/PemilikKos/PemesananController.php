<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Kos;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // List semua pemesanan untuk kos pemilik
    public function index(Request $request)
    {
        $query = Pemesanan::with(['kos', 'pencari', 'pembayaran'])
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            });

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by kos
        if ($request->has('kos_id') && $request->kos_id != '') {
            $query->where('kos_id', $request->kos_id);
        }

        $pemesanan = $query->latest()->paginate(15);

        // Get kos list for filter
        $kosList = Kos::where('pemilik_id', Auth::id())->get();

        return view('pemilik.pemesanan.index', compact('pemesanan', 'kosList'));
    }

    // Detail pemesanan
    public function show($id)
    {
        $pemesanan = Pemesanan::with(['kos', 'pencari', 'pembayaran'])
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            })
            ->findOrFail($id);

        return view('pemilik.pemesanan.show', compact('pemesanan'));
    }

    // Setujui pemesanan
    public function approve($id)
    {
        $pemesanan = Pemesanan::with('kos')
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            })
            ->findOrFail($id);

        if ($pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dalam status pending.');
        }

        // Check ketersediaan kamar
        if ($pemesanan->kos->kamar_tersedia < 1) {
            return back()->with('error', 'Kamar sudah penuh.');
        }

        // Update pemesanan status
        $pemesanan->update([
            'status' => 'disetujui',
            'tanggal_disetujui' => now(),
        ]);

        // Kurangi kamar tersedia
        $pemesanan->kos->decrement('kamar_tersedia');

        // Kirim notifikasi ke pencari
        Notifikasi::kirim(
            $pemesanan->pencari_id,
            'Pemesanan Disetujui',
            "Pemesanan Anda untuk {$pemesanan->kos->nama_kos} telah disetujui. Silakan lakukan pembayaran.",
            'success',
            route('pencari.pemesanan.show', $pemesanan->id)
        );

        return back()->with('success', 'Pemesanan berhasil disetujui!');
    }

    // Tolak pemesanan
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:10',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi',
            'alasan_penolakan.min' => 'Alasan minimal 10 karakter',
        ]);

        $pemesanan = Pemesanan::with('kos')
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            })
            ->findOrFail($id);

        if ($pemesanan->status !== 'pending') {
            return back()->with('error', 'Pemesanan tidak dalam status pending.');
        }

        $pemesanan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        // Kirim notifikasi ke pencari
        Notifikasi::kirim(
            $pemesanan->pencari_id,
            'Pemesanan Ditolak',
            "Pemesanan Anda untuk {$pemesanan->kos->nama_kos} ditolak. Alasan: {$request->alasan_penolakan}",
            'danger',
            route('pencari.pemesanan.show', $pemesanan->id)
        );

        return back()->with('success', 'Pemesanan berhasil ditolak.');
    }

    // Verifikasi pembayaran
    public function verifyPayment($id)
    {
        $pemesanan = Pemesanan::with(['kos', 'pembayaran'])
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            })
            ->findOrFail($id);

        if ($pemesanan->status !== 'dibayar') {
            return back()->with('error', 'Pembayaran belum diupload oleh pencari.');
        }

        // Get latest pembayaran with pending status
        $pembayaran = $pemesanan->pembayaran()
            ->where('status', 'pending')
            ->latest()
            ->first();
        
        if (!$pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan atau sudah diverifikasi.');
        }

        // Update pembayaran status
        $pembayaran->update([
            'status' => 'berhasil',
            'tanggal_verifikasi' => now(),
        ]);

        // Update pemesanan status menjadi AKTIF
        $pemesanan->update([
            'status' => 'aktif',
        ]);

        // Kirim notifikasi ke pencari
        Notifikasi::kirim(
            $pemesanan->pencari_id,
            'Pembayaran Diverifikasi',
            "Pembayaran Anda untuk {$pemesanan->kos->nama_kos} telah diverifikasi. Pemesanan sekarang aktif!",
            'success',
            route('pencari.pemesanan.show', $pemesanan->id)
        );

        return back()->with('success', 'Pembayaran berhasil diverifikasi! Pemesanan sekarang aktif.');
    }

    // Tolak pembayaran
    public function rejectPayment(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:10',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi',
            'alasan_penolakan.min' => 'Alasan minimal 10 karakter',
        ]);

        $pemesanan = Pemesanan::with(['kos', 'pembayaran'])
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            })
            ->findOrFail($id);

        if ($pemesanan->status !== 'dibayar') {
            return back()->with('error', 'Pembayaran belum diupload.');
        }

        // Get latest pembayaran with pending status
        $pembayaran = $pemesanan->pembayaran()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan atau sudah diverifikasi.');
        }

        // Update pembayaran status
        $pembayaran->update([
            'status' => 'gagal',
            'catatan' => $request->alasan_penolakan,
        ]);

        // Revert pemesanan status ke disetujui
        $pemesanan->update([
            'status' => 'disetujui',
        ]);

        // Kirim notifikasi ke pencari
        Notifikasi::kirim(
            $pemesanan->pencari_id,
            'Pembayaran Ditolak',
            "Pembayaran Anda untuk {$pemesanan->kos->nama_kos} ditolak. Alasan: {$request->alasan_penolakan}. Silakan upload ulang bukti pembayaran.",
            'warning',
            route('pencari.pemesanan.show', $pemesanan->id)
        );

        return back()->with('success', 'Pembayaran ditolak. Pencari harus upload ulang bukti pembayaran yang benar.');
    }

    // Selesaikan pemesanan
    public function complete($id)
    {
        $pemesanan = Pemesanan::with('kos')
            ->whereHas('kos', function ($q) {
                $q->where('pemilik_id', Auth::id());
            })
            ->findOrFail($id);

        if ($pemesanan->status !== 'aktif') {
            return back()->with('error', 'Pemesanan tidak dalam status aktif.');
        }

        $pemesanan->update([
            'status' => 'selesai',
        ]);

        // Kembalikan kamar tersedia
        $pemesanan->kos->increment('kamar_tersedia');

        return back()->with('success', 'Pemesanan telah selesai. Kamar tersedia telah dikembalikan.');
    }
}
