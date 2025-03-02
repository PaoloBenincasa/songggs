<?php

namespace App\Models;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['artist_id', 'title', 'lyrics', 'notes', 'spotify_url', 'mp3_audio', 'privacy'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

   
}
