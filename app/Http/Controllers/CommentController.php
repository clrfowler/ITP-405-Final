<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $albumId = $request->input('album_id');
        $commentText = $request->input('comment');

        $validatedData = [
            'id' => 1,
            'album_id' => $albumId,
            'user_id' => auth()->id(), 
            'comment_text' => $commentText,
            'comment_date' => now()->format('Y-m-d'), 
        ];
  
        $comment = Comment::create($validatedData);
     
    
        return redirect()->route('album.details', ['albumId' => $validatedData['album_id']])
                    ->with('success', 'Comment added successfully.')
                    ->with('comments', Comment::where('album_id', $validatedData['album_id'])->get());
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return view('comments', compact('comment'));
    }

    public function update(Request $request, $id)
    {

        $comment = Comment::findOrFail($id);
    
        $comment->comment_text = $request->input('comment');
        $comment->save();
        return redirect()->route('album.details', ['albumId' => $comment->album_id])
            ->with('success', 'Comment updated successfully.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return redirect()->route('album.details', ['albumId' => $comment->album_id])
            ->with('success', 'Comment deleted successfully.');
    }
}
