<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function homepage() {
        $songs = Song::where('privacy', false)->orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        $artist = $user ? $user->artist : null;
        $artists = Artist::all();
        $latestArtists = Artist::latest()->take(3)->get();

    
        view()->share('artist', $artist);
    
        return view('welcome', compact('songs', 'artists', 'latestArtists'));
    }
    
    
    
    

    public function dashboard()
    {
        $user = Auth::user();
        $artist = $user ? $user->artist : null;
        $artists = Artist::all();


        return view('dashboard', compact('artist'));
    }

    public function search(Request $request)
{
    $search = $request->input('search');
    $user = Auth::user();
    $artist = $user ? $user->artist : null; 
    $loggedInArtist = $artist; 

    $artists = collect();
    $songs = collect();

    if ($search) {
        $artists = Artist::where('name', 'like', '%' . $search . '%')->get();

        $songsQuery = Song::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('lyrics', 'like', '%' . $search . '%')
                  ->orWhere('notes', 'like', '%' . $search . '%');
        });

        if (Auth::check()) {
            $songsQuery->where(function ($query) {
                $query->where('privacy', false)
                      ->orWhere('artist_id', Auth::user()->artist->id);
            });
        } else {
            $songsQuery->where('privacy', false);
        }

        $songs = $songsQuery->get();
    }

    return view('search', compact('artists', 'songs', 'search', 'artist', 'loggedInArtist', 'user'));
}
}
