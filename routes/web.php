<?php

use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Rotte pubbliche
Route::get('/', [PublicController::class, 'homepage'])->name('welcome');
Route::get('/search', [PublicController::class, 'search'])->name('search');

// Rotte per gli artisti
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index'); // Visualizza gli artisti
Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show'); // Mostra un artista specifico

// Rotte protette (solo per utenti autenticati)
Route::middleware(['auth'])->group(function () {
    // Dashboard per l'utente (gestione artista)
    Route::get('/dashboard', [PublicController::class, 'dashboard'])->name('dashboard');

    // Rotte per la gestione degli artisti
    Route::get('/artists/create', [ArtistController::class, 'create'])->name('artists.create'); // Crea nuovo artista
    Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store'); // Salva nuovo artista
    Route::get('/artists/{artist}/edit', [ArtistController::class, 'edit'])->name('artists.edit'); // Modifica artista
    Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update'); // Aggiorna artista
    Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy'); // Elimina artista

    // Rotte per la gestione delle canzoni
    Route::get('/songs', [SongController::class, 'index'])->name('songs.index'); // Elenco delle canzoni
    Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create'); // Crea nuova canzone
    Route::post('/songs', [SongController::class, 'store'])->name('songs.store'); // Salva nuova canzone
    Route::get('/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit'); // Modifica una canzone
    Route::put('/songs/{song}', [SongController::class, 'update'])->name('songs.update'); // Aggiorna una canzone
    Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy'); // Elimina una canzone
});

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/songs/{song}', [SongController::class, 'show'])->name('songs.show'); // Mostra una canzone specifica
// Rotte per la registrazione e il login (solo per guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Logout (solo per utenti autenticati)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');