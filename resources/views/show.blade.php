<?php

use App\Models\EvolutionChain;

$typeColors = [
    'normal' => '#A8A77A',
    'fire' => '#EE8130',
    'water' => '#6390F0',
    'electric' => '#F7D02C',
    'grass' => '#7AC74C',
    'ice' => '#96D9D6',
    'fighting' => '#C22E28',
    'poison' => '#A33EA1',
    'ground' => '#E2BF65',
    'flying' => '#A98FF3',
    'psychic' => '#F95587',
    'bug' => '#A6B91A',
    'rock' => '#B6A136',
    'ghost' => '#735797',
    'dragon' => '#6F35FC',
    'dark' => '#705746',
    'steel' => '#B7B7CE',
    'fairy' => '#D685AD'
];

function getFirstInChain($pokemonId)
{
    $pokemonChain = EvolutionChain::where('pokemon_id', $pokemonId)->first();

    // Se não encontrar o Pokémon na tabela EvolutionChain, retorna nulo.
    if ($pokemonChain === null) {
        return null;
    }

    // Busca o primeiro Pokémon na cadeia de evolução.
    $firstInChain = EvolutionChain::where('pokemon_id', $pokemonChain->chain_id)->first();

    while ($firstInChain->evolves_from !== null) {
        $firstInChain = EvolutionChain::where('pokemon_id', $firstInChain->evolves_from)->first();
    }

    return $firstInChain;
}


function getEvolutionChain($pokemonId)
{
    $firstInChain = getFirstInChain($pokemonId);
    $evolutionChain = [];

    while ($firstInChain !== null) {
        $evolution = [
            'name' => $firstInChain->pokemon->name,
            'sprite' => $firstInChain->sprite,
        ];

        array_push($evolutionChain, $evolution);

        $firstInChain = EvolutionChain::where('evolves_from', $firstInChain->pokemon_id)->first();
    }

    return $evolutionChain;
}



?>

   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($pokemon->name) }} - Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">  
    <style>

.back-arrow {
        font-size: 2rem;
        position: absolute;
        top: 20px;
        left: 20px;
        text-decoration: none;
        color: #333;
    }

    .back-arrow:hover {
        color: #777;
    }   
    body {
        font-family: 'Roboto', sans-serif;
    }
    
    h1, h2 {
        margin-bottom: 15px;
    }
    
    .row > div {
        margin-bottom: 20px;
    }
    
    .type {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        color: white;
    }
    
    .stat-bar {
        background-color: #e0e0e0;
        border-radius: 4px;
        height: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .stat-bar span {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .details-container {
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    @media (max-width: 575.98px) {
        .details-container {
            padding: 15px;
        }
        
        .row > div {
            margin-bottom: 10px;
        }
    }
</style>

</head>
<body>
<a href="{{ route('pokemons.index') }}" class="back-arrow">&#8592;</a>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <div class="details-container">
                <div class="text-center">
                    <h1>{{ ucfirst($pokemon->name) }}</h1>
                    <div>
                        @foreach(explode(',', $pokemon->type) as $type)
                            <span class="type" style="background-color: {{ $typeColors[trim($type)] }}">{{ ucfirst(trim($type)) }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-6">
                        <h2>Profile</h2>
                        <p><strong>Height:</strong> <span>{{ $pokemon->height }}</span></p>
                        <p><strong>Weight:</strong> <span>{{ $pokemon->weight }}</span></p>
                        <p><strong>Catch Rate:</strong> <span>{{ $pokemon->catch_rate }}</span></p>
                        <p><strong>Gender Ratio:</strong> <span>{{ $pokemon->gender_ratio }}</span></p>
                        <p><strong>Egg Groups:</strong> <span>{{ $pokemon->egg_groups }}</span></p>
                        <p><strong>Hatch Steps:</strong> <span>{{ $pokemon->hatch_steps }}</span></p>
                        <p><strong>Abilities:</strong> <span>{{ $pokemon->abilities }}</span></p>
                        <p><strong>EVs:</strong> <span>{{ str_replace(',', '', $pokemon->evs) }}</span></p>                    </div>
                    <div class="col-6">
                    <h2>Stats</h2>
                    <p><strong>HP:</strong>
                        <div class="stat-bar">
                            <span style="width: {{ ($pokemon->hp / 255) * 100 }}%; background-color: #FF0000;"></span>
                            <span style="position: absolute; left: 0; top: 0; height: 100%; color: black; text-align: center; width: 100%;">{{ $pokemon->hp }}</span>
                        </div>
                    </p>
                    <p><strong>Attack:</strong>
                        <div class="stat-bar">
                            <span style="width: {{ ($pokemon->attack / 255) * 100 }}%; background-color: #F08030;"></span>
                            <span style="position: absolute; left: 0; top: 0; height: 100%; color: black; text-align: center; width: 100%;">{{ $pokemon->attack }}</span>
                        </div>
                    </p>
                    <p><strong>Defense:</strong>
                        <div class="stat-bar">
                            <span style="width: {{ ($pokemon->defense / 255) * 100 }}%;background-color: #F8D030;"></span>
                            <span style="position: absolute; left: 0; top: 0; height: 100%; color: black; text-align: center; width: 100%;">{{ $pokemon->defense }}</span>
                        </div>
                    </p>
                    <p><strong>Speed:</strong>
                        <div class="stat-bar">
                            <span style="width: {{ ($pokemon->speed / 255) * 100 }}%; background-color: #6890F0;"></span>
                            <span style="position: absolute; left: 0; top: 0; height: 100%; color: black; text-align: center; width: 100%;">{{ $pokemon->speed }}</span>
                        </div>
                    </p>
                    <p><strong>Sp. Atk:</strong>
                        <div class="stat-bar">
                            <span style="width: {{ ($pokemon->sp_atk / 255) * 100 }}%; background-color: #78C850;"></span>
                            <span style="position: absolute; left: 0; top: 0; height: 100%; color: black; text-align: center; width: 100%;">{{ $pokemon->sp_atk }}</span>
                        </div>
                    </p>
                    <p><strong>Sp. Def:</strong>
                        <div class="stat-bar">
                            <span style="width: {{ ($pokemon->sp_def / 255) * 100 }}%; background-color: #F85888;"></span>
                            <span style="position: absolute; left: 0; top: 0; height: 100%; color: black; text-align: center; width: 100%;">{{ $pokemon->sp_def }}</span>
                        </div>
                        </p>
                        </div>
                        </div>
                        <h2 class="text-center mt-5">Evolutions</h2>
                        <div class="text-center">
    @foreach($evolutionChain as $evolution)
        @if (!$loop->first)
            <span style="font-size: 2rem;">&rarr;</span>
        @endif
        <img src="{{ $evolution['sprite'] }}" alt="{{ $evolution['name'] }}" title="{{ ucfirst($evolution['name']) }}">
    @endforeach
</div>

            </div>
    </div>
</div>
</body>
<script>
    const typeColors = <?php echo json_encode($typeColors); ?>;
    const pokemonTypes = <?php echo json_encode(explode(',', $pokemon->type)); ?>;

    function setBackgroundColor() {
        if (pokemonTypes.length === 1) {
            document.body.style.backgroundColor = typeColors[pokemonTypes[0].trim()];
        } else {
            document.body.style.backgroundImage = `linear-gradient(90deg, ${typeColors[pokemonTypes[0].trim()]} 50%, ${typeColors[pokemonTypes[1].trim()]} 50%)`;
        }
    }

    setBackgroundColor();
</script>

</html>
