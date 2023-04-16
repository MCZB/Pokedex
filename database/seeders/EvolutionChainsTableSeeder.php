<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvolutionChain;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Http;

class EvolutionChainsTableSeeder extends Seeder
{
    public function run()
    {
        $apiEndpoint = "https://pokeapi.co/api/v2/evolution-chain?limit=898";
        $response = Http::get($apiEndpoint);

        if ($response->successful()) {
            $evolutionChains = $response->json()['results'];

            foreach ($evolutionChains as $chain) {
                $chainData = Http::get($chain['url'])->json();

                $this->storeEvolutionChain($chainData['chain']);
            }
        }
    }

    private function storeEvolutionChain($chain, $evolvesFromId = null)
    {
        $pokemon = Pokemon::where('name', $chain['species']['name'])->first();

        if ($pokemon) {
            $evolutionChain = new EvolutionChain();
            $evolutionChain->pokemon_id = $pokemon->id;
            $evolutionChain->evolves_from = $evolvesFromId;

            // Obter a sprite do Pokémon pelo nome
            $spriteEndpoint = "https://pokeapi.co/api/v2/pokemon/{$pokemon->name}";
            $spriteResponse = Http::get($spriteEndpoint);

            if ($spriteResponse->successful()) {
                $pokemonData = $spriteResponse->json();
                $evolutionChain->sprite = $pokemonData['sprites']['front_default'];
            }

            if (count($chain['evolves_to']) > 0) {
                $nextPokemon = Pokemon::where('name', $chain['evolves_to'][0]['species']['name'])->first();
                if ($nextPokemon) {
                    $evolutionChain->evolves_to = $nextPokemon->id;
                }
            }

            $evolutionChain->save();

            foreach ($chain['evolves_to'] as $evolution) {
                $this->storeEvolutionChain($evolution, $pokemon->id);
            }
        }
    }
}
