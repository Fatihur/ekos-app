<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();
        return view('pencari.profil.index', compact('pengguna'));
    }

    public function update(Request $request)
    {
        $pengguna = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'telepon' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->telepon = $request->telepon;

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($pengguna->foto_profil) {
                Storage::disk('public')->delete($pengguna->foto_profil);
            }
            $pengguna->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return redirect()->route('pencari.profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}
