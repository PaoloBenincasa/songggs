<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\SongController;
// use App\Http\Controllers\ArtistController;
// use App\Http\Controllers\PublicController;
// use Laravel\Fortify\Http\Controllers\RegisteredUserController;
// use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Route::get('/', [PublicController::class, 'homepage'])->name('welcome');
// // Route::resource('artists', ArtistController::class);
// // Route::resource('songs', SongController::class);
// Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');
// Route::post('artists', [ArtistController::class, 'store'])->name('artists.store');
// // Mostra la dashboard degli artisti
// // Mostra la dashboard di un artista specifico
// Route::get('artists', [ArtistController::class, 'index'])->name('artists.index'); // Visualizza gli artisti
// Route::get('artists/create', [ArtistController::class, 'create'])->name('artists.create')->middleware('auth'); // Crea nuovo artista
// Route::get('artists/{artist}/edit', [ArtistController::class, 'edit'])->name('artists.edit')->middleware('auth'); // Modifica artista
// Route::put('artists/{artist}', [ArtistController::class, 'update'])->name('artists.update')->middleware('auth'); // Aggiorna artista
// Route::delete('artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy')->middleware('auth'); // Elimina artista

// Route::middleware(['auth'])->group(function () {
//     // Dashboard per l'utente (gestione artista)
//     Route::get('/dashboard', [PublicController::class, 'dashboard'])->name('dashboard');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create');
//     Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
//     Route::get('/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit');
//     Route::put('/songs/{song}', [SongController::class, 'update'])->name('songs.update');
// });

// Route::get('songs.index', [SongController::class, 'index'])->name('songs.index');
// Route::get('/songs/{song}', [SongController::class, 'show'])->middleware('can:view,song')->name('songs.show');
// Route::delete('/songs/{id}', [SongController::class, 'destroy'])->name('songs.destroy');



// Route::get('/search', [PublicController::class, 'search'])->name('search');

// Route::group(['middleware' => ['guest']], function () {
//     // Mostra il form di registrazione
//     Route::get('/register', function () {
//         return view('auth.register');
//     })->name('register');

//     // Mostra il form di login
//     Route::get('/login', function () {
//         return view('auth.login');
//     })->name('login');
// });

// // Gestisce la registrazione degli utenti
// Route::post('/register', [RegisteredUserController::class, 'store']);

// // Gestisce il login degli utenti
// Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// // Logout (solo per utenti autenticati)
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//     ->middleware('auth', 'web')
//     ->name('logout');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PublicController;
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