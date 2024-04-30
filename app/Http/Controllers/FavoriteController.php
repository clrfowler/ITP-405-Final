<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $validated = $request->validate([
            'albumId' => 'required|string',
            'albumName' => 'required|string',
            'albumArtist' => 'required|string',
        ]);

        $album = Album::firstOrCreate(
            ['id' => $validated['albumId']],
            [
                'album_name' => $validated['albumName'],
                'artist_name' => $validated['albumArtist'],
            ]
        );

        $user = Auth::user();
        $isFavorited = $user->favoritedAlbums()->where('album_id', $album->id)->exists();

        if ($isFavorited) {
            $user->favoritedAlbums()->detach($album->id);
            session()->flash('status', 'Album unfavorited successfully!');
        } else {
            $user->favoritedAlbums()->attach($album->id);
            $album->touch(); 
            session()->flash('status', 'Album favorited successfully!');
        }

        return back()->with('status', session('status'));
    }
}
