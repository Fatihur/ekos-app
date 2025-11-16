<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'telepon' => $validated['telepon'],
            'password' => Hash::make($validated['password']),
            'peran' => $validated['peran'],
            'aktif' => true,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        if ($user->peran === 'pemilik_kos') {
            return redirect()->route('pemilik.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        } else {
            return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang.');
        }
    }
}
