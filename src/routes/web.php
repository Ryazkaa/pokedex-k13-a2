<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokedexCatchController;
use App\Http\Controllers\PokedexController;
use App\Http\Controllers\PokemonLibraryController;
use App\Http\Controllers\TrainerJournalController;
use Illuminate\Support\Facades\Route;

// Redirect root to pokedex
Route::redirect('/', '/pokedex');

// ==============================================================================
// MODUL 1: AUTENTIKASI & SESI TRAINER (Yanuar Dwi Putra)
// ==============================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/trainer/switch/{id}', [AuthController::class, 'switchTrainer'])->name('trainer.switch');

// ==============================================================================
// MODUL 2: MASTER POKEMON LIBRARY & PHPSPREADSHEET IMPORT (Arya Andra Diazka)
// ==============================================================================
Route::post('/pokemon-library/import', [PokemonLibraryController::class, 'import'])->name('library.import');

// ==============================================================================
// MODUL 3: DATATABLES CAUGHT TRACKER & EKSPOR PDF (Madina Dwiyana Putri)
// ==============================================================================
Route::post('/pokedex/toggle-catch/{pokemonId}', [PokedexCatchController::class, 'toggleCatch'])->name('pokedex.toggleCatch');
Route::post('/pokedex/toggle-favorite/{pokemonId}', [PokedexCatchController::class, 'toggleFavorite'])->name('pokedex.toggleFavorite');
Route::get('/pokedex/export-pdf', [PokedexCatchController::class, 'exportPdf'])->name('pokedex.exportPdf');

// ==============================================================================
// MODUL 4: WYSIWYG EDITOR & JURNAL STRATEGI TRAINER (Iasha Irdanti)
// ==============================================================================
Route::get('/pokedex/notes/{pokemonId}', [TrainerJournalController::class, 'show'])->name('pokedex.notes.show');
Route::post('/pokedex/notes/{pokemonId}', [TrainerJournalController::class, 'store'])->name('pokedex.notes.store');
Route::delete('/pokedex/notes/{pokemonId}', [TrainerJournalController::class, 'destroy'])->name('pokedex.notes.destroy');

// ==============================================================================
// BASE POKEDEX CONTROLLER
// ==============================================================================
Route::controller(PokedexController::class)->prefix('pokedex')->name('pokedex.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/export', 'export')->name('export');
    Route::post('/import', 'import')->name('import');
});
