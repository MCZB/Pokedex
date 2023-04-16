<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvolutionChain extends Model
{
    use HasFactory;

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_id');
    }

    public function evolvesFrom()
    {
        return $this->belongsTo(self::class, 'evolves_from');
    }

    public function evolvesTo()
    {
        return $this->hasOne(self::class, 'evolves_from');
    }
}
