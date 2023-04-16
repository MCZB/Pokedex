<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use App\Models\EvolutionChain;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pokemons = Pokemon::all();
        return view('index', compact('pokemons'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */public function show(Pokemon $pokemon)
{
    $getEvolutionChain = function($pokemonId) {
        $pokemonChain = EvolutionChain::where('pokemon_id', $pokemonId)->first();
        $evolutionChain = [];

        while($pokemonChain !== null) {
            $evolution = [
                'name' => $pokemonChain->pokemon->name,
                'sprite' => $pokemonChain->sprite,
            ];

            array_push($evolutionChain, $evolution);

            $pokemonChain = EvolutionChain::where('evolves_from', $pokemonChain->pokemon_id)->first();
        }

        return $evolutionChain;
    };

    $evolutionChain = $getEvolutionChain($pokemon->id);

    return view('show', compact('pokemon', 'evolutionChain'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
