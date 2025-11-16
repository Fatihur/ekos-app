<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManajemenPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query();

        if ($request->has('peran') && $request->peran != '') {
            $query->where('peran', $request->peran);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('telepon', 'like', '%' . $request->search . '%');
            });
        }

        $penggunaList = $query->latest()->paginate(15);

        return view('admin.pengguna.index', compact('penggunaList'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'peran' => 'required|in:admin,pemilik_kos,pencari_kos',
            'telepon' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
            'telepon' => $request->telepon,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'aktif' => $request->has('aktif') ? true : false,
        ]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit(Pengguna $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'password' => 'nullable|min:6',
            'peran' => 'required|in:admin,pemilik_kos,pencari_kos',
            'telepon' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'peran' => $request->peran,
            'telepon' => $request->telepon,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'aktif' => $request->has('aktif') ? true : false,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diupdate');
    }

    public function destroy(Pengguna $pengguna)
    {
        if ($pengguna->id == auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
