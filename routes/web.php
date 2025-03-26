<?php

use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', [PublicController::class, 'homepage'])->name('welcome');
Route::get('/search', [PublicController::class, 'search'])->name('search');

Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index'); 
Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show'); 

// ROTTE PROTETTE
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PublicController::class, 'dashboard'])->name('dashboard');

    Route::get('/artists/create', [ArtistController::class, 'create'])->name('artists.create'); 
    Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
    Route::get('/artists/{artist}/edit', [ArtistController::class, 'edit'])->name('artists.edit'); 
    Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update'); 
    Route::delete('/artists/{artist}', [ArtistController::class, 'destroy'])->name('artists.destroy'); 

    Route::get('/songs', [SongController::class, 'index'])->name('songs.index'); 
    Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create'); 
    Route::post('/songs', [SongController::class, 'store'])->name('songs.store'); 
    Route::get('/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit'); 
    Route::put('/songs/{song}', [SongController::class, 'update'])->name('songs.update'); 
    Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy'); 
});

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/songs/{song}', [SongController::class, 'show'])->name('songs.show'); 
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

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');