<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Auth::user()->notifikasi()
            ->latest()
            ->paginate(20);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('pengguna_id', Auth::id())
            ->findOrFail($id);

        $notifikasi->markAsRead();

        if ($notifikasi->link) {
            return redirect($notifikasi->link);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    public function markAllAsRead()
    {
        Auth::user()->notifikasiBelumDibaca()->update([
            'dibaca' => true,
            'dibaca_pada' => now(),
        ]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => Auth::user()->notifikasiBelumDibaca()->count()
        ]);
    }
}
