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
// MODUL 1: AUTENTIKASI & SESI TRAINER (Yanuar Dwi Prasetya)
// ==============================================================================
if (class_exists(AuthController::class)) {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/trainer/switch/{id}', [AuthController::class, 'switchTrainer'])->name('trainer.switch');
} else {
    // Fallback safe dummy route agar view yang memanggil route('logout') tidak error sebelum controller dibuat
    Route::post('/logout', fn() => redirect('/'))->name('logout');
}

// ==============================================================================
// MODUL 2: MASTER POKEMON LIBRARY & PHPSPREADSHEET IMPORT (Arya Andra Diazka)
// ==============================================================================
if (class_exists(PokemonLibraryController::class)) {
    Route::post('/pokemon-library/import', [PokemonLibraryController::class, 'import'])->name('library.import');
}

// ==============================================================================
// MODUL 3: DATATABLES CAUGHT TRACKER & EKSPOR PDF/EXCEL (Madina Dwiyana Putri)
// ==============================================================================
if (class_exists(PokedexCatchController::class)) {
    Route::post('/pokedex/caught', [PokedexCatchController::class, 'store'])->name('pokedex.catch.store');
    Route::delete('/pokedex/caught/{pokemonId}', [PokedexCatchController::class, 'destroy'])->name('pokedex.caught.destroy');
    Route::post('/pokedex/toggle-favorite/{pokemonId}', [PokedexCatchController::class, 'toggleFavorite'])->name('pokedex.toggleFavorite');
    Route::get('/pokedex/export-excel', [PokedexCatchController::class, 'exportExcel'])->name('pokedex.exportExcel');
    Route::get('/pokedex/export-pdf', [PokedexCatchController::class, 'exportPdf'])->name('pokedex.exportPdf');
} else {
    Route::get('/pokedex/export-excel', fn() => redirect('/'))->name('pokedex.exportExcel');
    Route::get('/pokedex/export-pdf', fn() => redirect('/'))->name('pokedex.exportPdf');
    Route::post('/pokedex/caught', fn() => response()->json(['success' => false]))->name('pokedex.catch.store');
}

// ==============================================================================
// MODUL 4: WYSIWYG EDITOR & JURNAL STRATEGI TRAINER (Iasha Irdanti)
// ==============================================================================
if (class_exists(TrainerJournalController::class)) {
    Route::get('/pokedex/notes/{pokemonId}', [TrainerJournalController::class, 'show'])->name('pokedex.notes.show');
    Route::post('/pokedex/notes/{pokemonId}', [TrainerJournalController::class, 'store'])->name('pokedex.notes.store');
    Route::delete('/pokedex/notes/{pokemonId}', [TrainerJournalController::class, 'destroy'])->name('pokedex.notes.destroy');
}

// ==============================================================================
// BASE POKEDEX CONTROLLER
// ==============================================================================
use App\Http\Middleware\EnsureDeveloper;

Route::controller(PokedexController::class)->prefix('pokedex')->name('pokedex.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/export', 'export')->name('export');
    Route::post('/import', 'import')->name('import')->middleware(EnsureDeveloper::class);
});
