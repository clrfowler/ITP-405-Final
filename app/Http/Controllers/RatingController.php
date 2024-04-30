<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'rating' => 'required|integer|between:0,100',
        ]);

        $rating = new Rating();
        $rating->user_id = auth()->id();
        $rating->album_id = $request->album_id;
        $rating->rating = $request->rating;
        $rating->save();

        return redirect()->back()->with('success', 'Rating submitted successfully.');
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:0|max:100',
        ]);
    
        $rating = Rating::findOrFail($id);
    
        $rating->update($validatedData);
    
        return redirect()->back()->with('success', 'Rating updated successfully.');
    }
    
}
