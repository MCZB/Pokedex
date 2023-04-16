<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/', [PokemonController::class, 'index'])->name('pokemons.index');
Route::get('/pokemons/{pokemon}', [PokemonController::class, 'show'])->name('pokemons.show');
