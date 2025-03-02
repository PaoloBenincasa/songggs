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

    
        // Condividi la variabile con tutte le view
        view()->share('artist', $artist);
    
        return view('welcome', compact('songs', 'artists', 'latestArtists'));
    }
    
    
    
    

    public function dashboard()
    {
        // Verifica se l'utente ha già un artista
        $artist = Artist::where('user_id', auth()->id())->first();

        // Passa l'artista alla vista della dashboard
        return view('dashboard', compact('artist'));
    }

    public function search(Request $request)
{
    // Otteniamo il termine di ricerca (se presente)
    $search = $request->input('search');
    $user = Auth::user();
    $artist = $user ? $user->artist : null; // Artista associato all'utente loggato
    $loggedInArtist = $artist; // Alias per chiarezza (opzionale)

    // Inizializza le variabili per i risultati
    $artists = collect();
    $songs = collect();

    // Se è stato inserito un termine di ricerca, esegui la query
    if ($search) {
        // Ricerca per artisti
        $artists = Artist::where('name', 'like', '%' . $search . '%')->get();

        // Ricerca per canzoni (per titolo, lyrics e notes)
        $songsQuery = Song::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('lyrics', 'like', '%' . $search . '%')
                  ->orWhere('notes', 'like', '%' . $search . '%');
        });

        // Filtra le canzoni private
        if (Auth::check()) {
            // Se l'utente è loggato, mostra le canzoni private solo se è l'artista
            $songsQuery->where(function ($query) {
                $query->where('privacy', false)
                      ->orWhere('artist_id', Auth::user()->artist->id);
            });
        } else {
            // Se l'utente non è loggato, mostra solo le canzoni pubbliche
            $songsQuery->where('privacy', false);
        }

        // Esegui la query
        $songs = $songsQuery->get();
    }

    // Passiamo i risultati alla vista corretta (search.page)
    return view('search', compact('artists', 'songs', 'search', 'artist', 'loggedInArtist', 'user'));
}
}
