<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
{
   
    public function index()
{
    $user = Auth::user();
    $artist = $user ? $user->artist : null; 
    $artists = Artist::all(); 

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
    $request->validate([
        'name' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:10240', 
    ]);

    $artist = new Artist();
    $artist->name = $request->name;
    $artist->bio = $request->bio;
    $artist->user_id = auth()->id(); 


    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $artist->profile_picture = $path; 
        
    }

    $artist->save();

    return redirect()->route('artists.index');
}


    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        $user = Auth::user();
        $loggedInArtist = $user ? $user->artist : null; 

        if (auth()->check() && auth()->id() === $artist->user_id) {
            $songs = $artist->songs; 
        } else {
            $songs = $artist->songs()->where('privacy', false)->get(); 
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
        $artist = Artist::findOrFail($id);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $artist->profile_picture = $path; 
            
        }

       
        $artist->name = $request->input('name');
        $artist->bio = $request->input('bio');
       
        $artist->save();

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
        if ($artist->user_id !== auth()->id()) {
            abort(403, 'Non hai accesso a questa dashboard');
        }
    
        return view('artists.dashboard', compact('artist'));
    }
    

}
