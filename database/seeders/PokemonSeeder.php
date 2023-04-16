<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PokemonSeeder extends Seeder
{
    public function run()
    {
        $evolution_chains = Http::get('https://pokeapi.co/api/v2/evolution-chain?limit=478')->json()['results'];

        foreach ($evolution_chains as $evolution_chain) {
            $chain = Http::get($evolution_chain['url'])->json();

            $this->storePokemon($chain['chain']);
        }
    }

    private function storePokemon($chain)
    {
        $pokemon_id = $chain['species']['url'];
        $pokemon_id = explode('/', rtrim($pokemon_id, '/'));
        $pokemon_id = end($pokemon_id);
        $pokemon_data = Http::get('https://pokeapi.co/api/v2/pokemon/' . $pokemon_id)->json();
        $pokemon_species_data = Http::get('https://pokeapi.co/api/v2/pokemon-species/' . $pokemon_id)->json();

        $evolutions = $this->extractEvolutions($chain);

        $male_percentage = (8 - $pokemon_species_data['gender_rate']) * 12.5;
        $female_percentage = $pokemon_species_data['gender_rate'] * 12.5;

        Pokemon::create([
            'pokemon_id' => $pokemon_id,
            'name' => $pokemon_data['name'],
            'sprite' => $pokemon_data['sprites']['front_default'],
            'type' => implode(', ', array_map(function ($type) {
                return $type['type']['name'];
            }, $pokemon_data['types'])),
            'hp' => $pokemon_data['stats'][0]['base_stat'],
            'attack' => $pokemon_data['stats'][1]['base_stat'],
            'defense' => $pokemon_data['stats'][2]['base_stat'],
            'speed' => $pokemon_data['stats'][5]['base_stat'],
            'sp_atk' => $pokemon_data['stats'][3]['base_stat'],
            'sp_def' => $pokemon_data['stats'][4]['base_stat'],
            'seed_pokemon' => $chain['species']['name'],
            'height' => $pokemon_data['height'],
            'weight' => $pokemon_data['weight'],
            'abilities' => implode(', ', array_map(function ($ability) {
                return $ability['ability']['name'];
            }, $pokemon_data['abilities'])),
            'evs' => implode(', ', array_map(function ($stat) {
                return $stat['effort'] > 0 ? $stat['stat']['name'] . ': ' . $stat['effort'] : null;
            }, $pokemon_data['stats'])),
            'catch_rate' => $pokemon_species_data['capture_rate'],
            'gender_ratio' => "{$male_percentage}% / {$female_percentage}%",
            'egg_groups' => implode(', ', array_map(function ($egg_group) {
                return $egg_group['name'];
            }, $pokemon_species_data['egg_groups'])),
            'hatch_steps' => $pokemon_species_data['hatch_counter'] * 255,
            'evolution_chain' => implode(', ', $evolutions),
        ]);

        foreach ($chain['evolves_to'] as $evolution) {
            $this->storePokemon($evolution);
        }
    }

    private function extractEvolutions($chain)
    {
        $evolutions = [];

        foreach ($chain['evolves_to'] as $evolution) {
            $evolutions[] = $evolution['species']['name'];
            $evolutions = array_merge($evolutions, $this->extractEvolutions($evolution));
        }

        return $evolutions;
    }
}
