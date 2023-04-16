<!DOCTYPE html>
<html lang="en">
<head>
<?php
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
function getNextEvolution($pokemon) {
    if (!$pokemon->next_evolution) {
        return null;
    }

    return $pokemon->next_evolution;
}
?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(ucfirst($pokemon->name)); ?> - Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
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
        }
        .stat-bar span {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            border-radius: 4px;
        }
        .details-container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <div class="details-container">
                <div class="text-center">
                    <h1><?php echo e(ucfirst($pokemon->name)); ?></h1>
                    <div>
                        <?php $__currentLoopData = explode(',', $pokemon->type); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="type" style="background-color: <?php echo e($typeColors[trim($type)]); ?>"><?php echo e(ucfirst(trim($type))); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-6">
                        <h2>Profile</h2>
                        <p><strong>Height:</strong> <span><?php echo e($pokemon->height); ?></span></p>
                        <p><strong>Weight:</strong> <span><?php echo e($pokemon->weight); ?></span></p>
                        <p><strong>Catch Rate:</strong> <span><?php echo e($pokemon->catch_rate); ?></span></p>
                        <p><strong>Gender Ratio:</strong> <span><?php echo e($pokemon->gender_ratio); ?></span></p>
                        <p><strong>Egg Groups:</strong> <span><?php echo e($pokemon->egg_groups); ?></span></p>
                        <p><strong>Hatch Steps:</strong> <span><?php echo e($pokemon->hatch_steps); ?></span></p>
                        <p><strong>Abilities:</strong> <span><?php echo e($pokemon->abilities); ?></span></p>
                        <p><strong>EVs:</strong> <span><?php echo e($pokemon->evs); ?></span></p>
                    </div>
                    <div class="col-6">
                        <h2>Stats</h2>
                        <p><strong>HP:</strong>
                            <div class="stat-bar">
                                <span style="width: <?php echo e($pokemon->hp / 255 * 100); ?>%; background-color: #FF0000;"></span>
                            </div>
                        </p>
                        <p><strong>Attack:</strong>
                            <div class="stat-bar">
                                <span style="width: <?php echo e($pokemon->attack / 255 * 100); ?>%; background-color: #F08030;"></span>
                            </div>
                        </p>
                        <p><strong>Defense:</strong>
                            <div class="stat-bar">
                                <span style="width: <?php echo e($pokemon->defense / 255 * 100); ?>%;background-color: #F8D030;"></span>
                        </div>
                        </p>
                        <p><strong>Speed:</strong>
                        <div class="stat-bar">
                        <span style="width: <?php echo e($pokemon->speed / 255 * 100); ?>%; background-color: #6890F0;"></span>
                        </div>
                        </p>
                        <p><strong>Sp. Atk:</strong>
                        <div class="stat-bar">
                        <span style="width: <?php echo e($pokemon->sp_atk / 255 * 100); ?>%; background-color: #78C850;"></span>
                        </div>
                        </p>
                        <p><strong>Sp. Def:</strong>
                        <div class="stat-bar">
                        <span style="width: <?php echo e($pokemon->sp_def / 255 * 100); ?>%; background-color: #F85888;"></span>
                        </div>
                        </p>
                        </div>
                        </div>
                        <h2 class="text-center mt-5">Evolutions</h2>
<div class="text-center">
    <?php if($nextEvolution = getNextEvolution($pokemon)): ?>
        <img src="<?php echo e($nextEvolution->sprite); ?>" alt="<?php echo e($nextEvolution->name); ?>">
    <?php else: ?>
        This Pokémon does not evolve further.
    <?php endif; ?>
</div>

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
<?php /**PATH E:\pokemonBackup\pokemon\resources\views/show.blade.php ENDPATH**/ ?>