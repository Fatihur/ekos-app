<?php

namespace App\Http\Controllers\PencariKos;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('kos')
            ->where('pengguna_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('pencari.bookmark.index', compact('bookmarks'));
    }

    public function toggle($kosId)
    {
        $bookmark = Bookmark::where('pengguna_id', Auth::id())
            ->where('kos_id', $kosId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', 'Kos dihapus dari favorit');
        } else {
            Bookmark::create([
                'pengguna_id' => Auth::id(),
                'kos_id' => $kosId,
            ]);
            return back()->with('success', 'Kos ditambahkan ke favorit');
        }
    }
}
