<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $fillable = [
        'username', 'password', 
    ];

    public function favoritedAlbums()
    {
        return $this->belongsToMany(Album::class, 'favorites', 'user_id', 'album_id')->withTimestamps();
    }

    /**
     * Toggle the favorite status of an album for the user.
     *
     * @param int $albumId
     * @return void
     */
    public function toggleFavorite($albumId)
    {
        if ($this->favoritedAlbums()->where('album_id', $albumId)->exists()) {
            $this->favoritedAlbums()->detach($albumId);
        } else {
            $this->favoritedAlbums()->attach($albumId);
        }
    }
}
