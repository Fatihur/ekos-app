<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\PemilikKos;
use App\Models\PencariKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'telepon' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'peran' => 'required|in:pemilik_kos,pencari_kos',
        ]);

        $user = Pengguna::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'peran' => $validated['peran'],
            'aktif' => true,
        ]);

        // Buat record di tabel terkait berdasarkan peran
        if ($validated['peran'] === 'pemilik_kos') {
            PemilikKos::create([
                'pengguna_id' => $user->id,
                'nama_lengkap' => $validated['nama'],
                'no_telpon' => $validated['telepon'],
            ]);
        } else {
            PencariKos::create([
                'pengguna_id' => $user->id,
                'nama_lengkap' => $validated['nama'],
                'no_telpon' => $validated['telepon'],
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
    }
}
