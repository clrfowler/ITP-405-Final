<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Album;
use App\Models\Comment;
use App\Models\Rating;
use App\Services\SpotifyService;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;

class AlbumController extends Controller
{
// compiles album details
    public function showDetails($albumId)
    {
        $accessToken = env('SPOTIFY_ACCESS_TOKEN');
        $spotifyService = new SpotifyService($accessToken);
    
        $album = $spotifyService->getAlbumDetails($albumId);
        
        $userRating = Rating::where('user_id', auth()->id())->where('album_id', $albumId)->first();
    
        $comments = Comment::where('album_id', $albumId)->get();
    
        return view('details', compact('album', 'userRating','comments'));
    }

}
