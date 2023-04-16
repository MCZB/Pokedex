<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            width: 160px;
            height: 160px;
            position: relative;
            border-radius: 12px; 
        }
        .card-body {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding-top: 4px;
            padding-bottom: 4px;
            background: 
            rgba(255, 255, 255, 0.8);
            border-radius: 0 0 12px 12px; 
        }
        .card-body h6 {
            color: black; 
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            width: 160px;
            height: 160px;
            position: relative;
            border-radius: 12px;
            transition: transform 0.3s; /* Adicione transição para a transformação do card */
        }
        .card:hover {
            transform: translateY(-10px); /* Mova o card para cima quando o mouse passar sobre ele */
        }
        .card-body {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding-top: 4px;
            padding-bottom: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 0 0 12px 12px;
        }
        .card-body h6 {
            color: black;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Pokémon</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Pokémon List</h1>
        <div class="row mb-4">
            <div class="col-md-12">
                <form id="searchForm" class="form-inline justify-content-center">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by name">
                </form>
            </div>
        </div>
        <div class="row" id="pokemonCards">
            @foreach($pokemons as $pokemon)
            <div class="col-md-2 mb-4">
                <div class="card" data-name="{{ $pokemon->name }}" data-types="{{ $pokemon->type }}">
                    <a href="{{ route('pokemons.show', $pokemon->id) }}" class="text-decoration-none">
                        <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="card-img-top" style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title text-center m-0">{{ ucfirst($pokemon->name) }}</h6>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const typeColors = {
            'normal': '#A8A77A',
            'fire': '#EE8130',
            'water': '#6390F0',
            'electric': '#F7D02C',
            'grass': '#7AC74C',
            'ice': '#96D9D6',
            'fighting': '#C22E28',
            'poison': '#A33EA1',
            'ground': '#E2BF65',
            'flying': '#A98FF3',
            'psychic': '#F95587',
            'bug': '#A6B91A',
            'rock': '#B6A136',
            'ghost': '#735797',
            'dragon': '#6F35FC',
            'dark': '#705746',
            'steel': '#B7B7CE',
            'fairy': '#D685AD'
        };

        document.querySelectorAll('.card').forEach(card => {
            const types = card.dataset.types.split(', ');
            const colors = types.map(type => typeColors[type] || '#999');
            const background = colors.length > 1 ? `linear-gradient(90deg, ${colors[0]} 50%, ${colors[1]} 50%)` : colors[0];
            card.style.background = background;
        });
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const pokemonCards = document.getElementById('pokemonCards');

        searchForm.addEventListener('input', () => {
            const searchValue = searchInput.value.trim().toLowerCase();
            const cards = pokemonCards.querySelectorAll('.col-md-2');

            cards.forEach(card => {
                const name = card.querySelector('.card').dataset.name.toLowerCase();
                const match = name.startsWith(searchValue);
                card.classList.toggle('hidden', !match);
            });
        });
    </script>
</body>
</html>