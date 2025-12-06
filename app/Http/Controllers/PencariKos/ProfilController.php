<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\PencariKos;
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

        // Update data pengguna
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        // Update data pencari kos
        $pencariKos = $pengguna->pencariKos ?? PencariKos::create(['pengguna_id' => $pengguna->id, 'nama_lengkap' => $request->nama]);

        $dataPencari = [
            'nama_lengkap' => $request->nama,
            'no_telpon' => $request->telepon,
        ];

        if ($request->hasFile('foto_profil')) {
            if ($pencariKos->foto_profil) {
                Storage::disk('public')->delete($pencariKos->foto_profil);
            }
            $dataPencari['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }

        $pencariKos->update($dataPencari);

        return redirect()->route('pencari.profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}
