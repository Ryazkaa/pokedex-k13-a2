<?php

use App\Http\Controllers\PokedexController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/pokedex');

Route::controller(PokedexController::class)->prefix('pokedex')->name('pokedex.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/export', 'export')->name('export');
    Route::post('/import', 'import')->name('import');
});
