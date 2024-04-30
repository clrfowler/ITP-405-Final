<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpotifyService;
use App\Models\Album; 
use Carbon\Carbon;
use App\Models\Rating;

class ProfileController extends Controller
{
    /**
     * Display the user's profile with favorited albums.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    // get user, their favorited albums, and their ratings
    public function index(Request $request)
    {
        $access = env('SPOTIFY_ACCESS_TOKEN');
        $spotifyService = new SpotifyService($access);
    
        $favoritedAlbums = auth()->user()->favoritedAlbums()->pluck('id')->toArray();
    
        $albums = $spotifyService->searchFavorites($favoritedAlbums);
    
        $favoritedAlbumIds = auth()->user()->favoritedAlbums()->pluck('id')->toArray();
     
        if($albums){
        foreach ($albums['albums'] as &$item) {
            $item['favorited'] = in_array($item['id'], $favoritedAlbumIds);
            if ($item['favorited']) {
                $album = Album::where('id', $item['id'])->first();
                $item['updated_at'] = $album->updated_at;
    
                $userRating = Rating::where('user_id', auth()->id())
                                    ->where('album_id', $album->id)
                                    ->value('rating');
    
                $item['user_rating'] = $userRating;
            }
        }
    }
    
        // Flash the request data for possible redirection
        $request->flash();
    
        if (!$albums) {
            $message = "No albums liked yet! Like an album to save it to your profile.";
            return view('profile', compact('message', 'albums'));
        } else {
            return view('profile', compact('albums', 'favoritedAlbums'));
        }
    }
}
    
