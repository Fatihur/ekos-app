<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\PemilikKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();
        return view('pemilik.pengaturan.index', compact('pengguna'));
    }

    public function update(Request $request)
    {
        $pengguna = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'telepon' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'nomor_rekening' => 'nullable|string|max:50',
            'nama_bank' => 'nullable|string|max:100',
            'nama_pemilik_rekening' => 'nullable|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'foto_profil.image' => 'File harus berupa gambar',
            'foto_profil.mimes' => 'Format foto: JPG, JPEG, PNG',
            'foto_profil.max' => 'Ukuran foto maksimal 2MB',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Update data pengguna (hanya nama dan email)
        $pengguna->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $pengguna->update(['password' => Hash::make($request->password)]);
        }

        // Update data pemilik kos
        $pemilikKos = $pengguna->pemilikKos ?? PemilikKos::create(['pengguna_id' => $pengguna->id, 'nama_lengkap' => $request->nama]);
        
        $dataPemilik = [
            'nama_lengkap' => $request->nama,
            'no_telpon' => $request->telepon,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_bank' => $request->nama_bank,
            'nama_pemilik_rekening' => $request->nama_pemilik_rekening,
        ];

        // Upload foto profil
        if ($request->hasFile('foto_profil')) {
            if ($pemilikKos->foto_profil) {
                Storage::disk('public')->delete($pemilikKos->foto_profil);
            }
            $dataPemilik['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }

        $pemilikKos->update($dataPemilik);

        return back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}
