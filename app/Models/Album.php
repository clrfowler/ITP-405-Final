<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;


class Album extends Model
{

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = ['id', 'album_name', 'artist_name', 'created_at', 'updated_at'];

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'album_id', 'user_id')->withTimestamps();
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
