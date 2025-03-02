<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = Auth::user();
    $artist = $user ? $user->artist : null; // Ottieni l'artista associato all'utente loggato
    $artists = Artist::all(); // Ottieni tutti gli artisti

    return view('artists.index', compact('artists', 'artist'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validazione dell'immagine
    $request->validate([
        'name' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:10240', // 10MB max
    ]);

    // Creazione dell'artista
    $artist = new Artist();
    $artist->name = $request->name;
    $artist->bio = $request->bio;
    $artist->user_id = auth()->id(); // Associa l'artista all'utente loggato


    // Se è presente un'immagine, salvala nella cartella e memorizza il nome nel DB
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $artist->profile_picture = $path; // Save the full path
        
    }

    // Salva l'artista nel database
    $artist->save();

    return redirect()->route('artists.index');
}


    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        $user = Auth::user();
        $loggedInArtist = $user ? $user->artist : null; // Ottieni l'artista associato all'utente loggato

        if (auth()->check() && auth()->id() === $artist->user_id) {
            $songs = $artist->songs; // Tutte le canzoni (pubbliche e private)
        } else {
            $songs = $artist->songs()->where('privacy', false)->get(); // Solo pubbliche
        }

    
        return view('artists.show', compact('artist', 'songs', 'loggedInArtist'));
    }

    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Trova l'artista
        $artist = Artist::findOrFail($id);

        // Verifica se è stato caricato un file
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $artist->profile_picture = $path; // Save the full path
            
        }

        // Salva gli altri dati dell'artista, se presenti
        // Ad esempio, se stai aggiornando il nome o la bio
        $artist->name = $request->input('name');
        $artist->bio = $request->input('bio');
        // Salva l'artista
        $artist->save();

        // Rispondi con una risposta, ad esempio un redirect o una view
        return redirect()->route('welcome');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('artists.index')->with('success', 'Artista eliminato con successo');
    }

    public function dashboard(Artist $artist)
    {
        // Verifica che l'artista appartenga all'utente attualmente autenticato
        if ($artist->user_id !== auth()->id()) {
            abort(403, 'Non hai accesso a questa dashboard');
        }
    
        // Passa l'artista alla vista della dashboard
        return view('artists.dashboard', compact('artist'));
    }
    

}
