<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpotifyService;
use App\Http\Controllers\FavoriteController;
use App\Models\Album;
use Carbon\Carbon;



class DashboardController extends Controller
{
    //indexes Spotify's top 20 albums of the day and keeps track of the ones favorited
     public function index()
     {
         $access = env('SPOTIFY_ACCESS_TOKEN');
         $spotifyService = new SpotifyService($access);
         $albums = $spotifyService->getTopAlbums(20); 
     
         $favoritedAlbumIds = auth()->user()->favoritedAlbums()->pluck('id')->toArray();
     
         foreach ($albums['albums']['items'] as &$album) {
            $album['favorited'] = in_array($album['id'], $favoritedAlbumIds);
            if ($album['favorited']) {
                $albumModel = Album::where('id', $album['id'])->first();
              
                $album['favorited_at'] = $albumModel['updated_at'];
            }
        }
        
     
         return view('dashboard', compact('albums'));
     }
     
//searches Spotify's API and returns results; keeps track of the ones favorited
    public function search(Request $request)
    {
        $access = env('SPOTIFY_ACCESS_TOKEN');
        $query = $request->input('query');
    
        $spotifyService = new SpotifyService($access);
        $albums = $spotifyService->searchAlbums($query);
    
        $favoritedAlbumIds = auth()->user()->favoritedAlbums()->pluck('id')->toArray();
    
        foreach ($albums['albums']['items'] as &$album) {
            $album['favorited'] = in_array($album['id'], $favoritedAlbumIds);
            if ($album['favorited']) {;
                $albumModel = Album::where('id', $album['id'])->first();
                $album['updated_at'] = $albumModel ? $albumModel->updated_at : null;
            }
        }
        
        
        $request->flash();
    
        return view('search', compact('albums', 'query'));
    }
    
}
