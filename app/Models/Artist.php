<?php

namespace App\Models;

use App\Models\Song;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'profile_picture', 'bio', 'location'];

    // Artist.php
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}



    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
