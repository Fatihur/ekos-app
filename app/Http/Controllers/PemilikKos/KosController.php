<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Http\Requests\KosRequest;
use App\Models\Kos;
use App\Models\Fasilitas;
use App\Models\FotoKos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KosController extends Controller
{
    public function index()
    {
        $kosList = Kos::where('pemilik_id', Auth::id())
            ->withCount('pemesanan')
            ->latest()
            ->paginate(10);

        return view('pemilik.kos.index', compact('kosList'));
    }

    public function create()
    {
        $fasilitas = Fasilitas::all();
        return view('pemilik.kos.create', compact('fasilitas'));
    }

    public function store(KosRequest $request)
    {
        $data = $request->validated();
        $data['pemilik_id'] = Auth::id();

        // Upload foto utama
        if ($request->hasFile('foto_utama')) {
            $data['foto_utama'] = $request->file('foto_utama')->store('kos', 'public');
        }

        $kos = Kos::create($data);

        // Attach fasilitas
        if ($request->has('fasilitas')) {
            $kos->fasilitas()->attach($request->fasilitas);
        }

        // Upload foto tambahan
        if ($request->hasFile('foto_tambahan')) {
            foreach ($request->file('foto_tambahan') as $index => $foto) {
                FotoKos::create([
                    'kos_id' => $kos->id,
                    'foto' => $foto->store('kos/galeri', 'public'),
                    'urutan' => $index + 1,
                ]);
            }
        }

        return redirect()->route('pemilik.kos.index')->with('success', 'Kos berhasil ditambahkan');
    }

    public function show(Kos $ko)
    {
        if ($ko->pemilik_id !== Auth::id()) {
            abort(403);
        }

        $ko->load(['fasilitas', 'foto', 'pemesanan' => function($query) {
            $query->latest()->limit(5);
        }]);

        return view('pemilik.kos.show', compact('ko'));
    }

    public function edit(Kos $ko)
    {
        if ($ko->pemilik_id !== Auth::id()) {
            abort(403);
        }

        $fasilitas = Fasilitas::all();
        $ko->load(['fasilitas', 'foto']);

        return view('pemilik.kos.edit', compact('ko', 'fasilitas'));
    }

    public function update(KosRequest $request, Kos $ko)
    {
        if ($ko->pemilik_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();

        // Upload foto utama baru
        if ($request->hasFile('foto_utama')) {
            if ($ko->foto_utama) {
                Storage::disk('public')->delete($ko->foto_utama);
            }
            $data['foto_utama'] = $request->file('foto_utama')->store('kos', 'public');
        }

        $ko->update($data);

        // Sync fasilitas
        if ($request->has('fasilitas')) {
            $ko->fasilitas()->sync($request->fasilitas);
        } else {
            $ko->fasilitas()->detach();
        }

        // Upload foto tambahan baru
        if ($request->hasFile('foto_tambahan')) {
            $lastUrutan = $ko->foto->max('urutan') ?? 0;
            foreach ($request->file('foto_tambahan') as $index => $foto) {
                FotoKos::create([
                    'kos_id' => $ko->id,
                    'foto' => $foto->store('kos/galeri', 'public'),
                    'urutan' => $lastUrutan + $index + 1,
                ]);
            }
        }

        return redirect()->route('pemilik.kos.index')->with('success', 'Kos berhasil diupdate');
    }

    public function destroy(Kos $ko)
    {
        if ($ko->pemilik_id !== Auth::id()) {
            abort(403);
        }

        // Hapus foto utama
        if ($ko->foto_utama) {
            Storage::disk('public')->delete($ko->foto_utama);
        }

        // Hapus foto tambahan
        foreach ($ko->foto as $foto) {
            Storage::disk('public')->delete($foto->foto);
            $foto->delete();
        }

        $ko->delete();

        return redirect()->route('pemilik.kos.index')->with('success', 'Kos berhasil dihapus');
    }

    public function deleteFoto($koId, $fotoId)
    {
        $foto = FotoKos::where('kos_id', $koId)->findOrFail($fotoId);
        
        if ($foto->kos->pemilik_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($foto->foto);
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
