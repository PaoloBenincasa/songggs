<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SongController extends Controller
{
   
    public function index()
    {
        $songs = Song::with('artist')->get();
        return view('songs.index', compact('songs'));
    }


    public function create()
    {
        $artist = auth()->user()->artist; 
        return view('songs.create', compact('artist'));
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'lyrics' => 'nullable|string',
            'notes' => 'nullable|string',
            'spotify_url' => ['nullable', 'regex:/^https:\/\/open\.spotify\.com\/track\/[a-zA-Z0-9]+$/'],
            'mp3_audio' => 'nullable|file|mimes:mp3|max:10240', 
            'privacy' => 'required|in:0,1', 
        ]);

        $data['artist_id'] = auth()->user()->artist->id;

        if ($request->hasFile('mp3_audio')) {
            $file = $request->file('mp3_audio');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/songs', $fileName, 'public'); 
            $data['mp3_audio'] = $filePath; 
        }

        Song::create($data);

        return redirect()->route('welcome')->with('success', 'Canzone aggiunta con successo');
    }

  
    public function show(Song $song)
    {
        $song->load('artist');
    
        if ($song->privacy) {
            if (auth()->id() !== $song->artist->user_id) {
                abort(403, 'Non hai il permesso di visualizzare questa canzone.');
            }
        }
    
        return view('songs.show', compact('song'));
    }

   
    public function edit(Song $song)
    {
        if (auth()->id() !== $song->artist->user_id) {
            abort(403, 'Non hai il permesso di modificare questa canzone.');
        }

        return view('songs.edit', compact('song'));
    }


    public function update(Request $request, Song $song)
    {
        if (auth()->id() !== $song->artist->user_id) {
            abort(403, 'Non hai il permesso di modificare questa canzone.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'lyrics' => 'nullable|string',
            'notes' => 'nullable|string',
            'spotify_url' => ['nullable', 'regex:/^https:\/\/open\.spotify\.com\/track\/[a-zA-Z0-9]+$/'],
            'mp3_audio' => 'nullable|file|mimes:mp3|max:10240', 
            'privacy' => 'required|in:0,1', 
        ]);

        if ($request->hasFile('mp3_audio')) {
            if ($song->mp3_audio) {
                Storage::disk('public')->delete($song->mp3_audio);
            }

            $file = $request->file('mp3_audio');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('songs', $fileName, 'public');
            $data['mp3_audio'] = $filePath;
        }

        $song->update($data);

        return redirect()->route('songs.show', $song)->with('success', 'Canzone aggiornata con successo!');
    }

 
    public function destroy(Song $song)
    {
        if (auth()->id() !== $song->artist->user_id) {
            abort(403, 'Non hai il permesso di eliminare questa canzone.');
        }

       

        if ($song->artist) {
            Log::info('Song artist user id: ' . $song->artist->user_id);
        } else {
            Log::info('Song has no artist associated.');
        }

      

        if ($song->mp3_audio) {
            Log::info('Deleting MP3 file: ' . $song->mp3_audio);
            Storage::disk('public')->delete($song->mp3_audio);
        }

        $song->delete();

        return redirect()->route('welcome')->with('success', 'Canzone eliminata con successo');
    }
}