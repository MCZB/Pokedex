<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ImportEvolutionSpritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $client = new Client([
            'base_uri' => 'https://pokeapi.co/api/v2/',
        ]);

        // Buscar as cadeias evolutivas
        $response = $client->get('evolution-chain?limit=898');
        $data = json_decode($response->getBody(), true);
        $evolutionChains = $data['results'];

        // Iterar sobre as cadeias evolutivas
        foreach ($evolutionChains as $evolutionChain) {
            $response = $client->get($evolutionChain['url']);
            $data = json_decode($response->getBody(), true);
            $chainId = $data['id'];

            // Iterar sobre as formas evolutivas da cadeia
            $firstInChain = $data['chain'];
            $current = $firstInChain;
            $stage = 1;

            do {
                // Associar a sprite à forma evolutiva
                $response = $client->get('pokemon/' . $current['species']['name']);
                $data = json_decode($response->getBody(), true);
                $sprite = $data['sprites']['front_default'];

                DB::table('evolution_chains')
                    ->where('pokemon_id', $current['species']['url'])
                    ->where('chain_id', $chainId)
                    ->update(['sprite' => $sprite, 'evolution_stage' => $stage]);

                // Avançar para a próxima forma evolutiva
                if (count($current['evolves_to']) > 0) {
                    $current = $current['evolves_to'][0];
                    $stage++;
                } else {
                    $current = null;
                }
            } while ($current !== null);
        }
    }
}
