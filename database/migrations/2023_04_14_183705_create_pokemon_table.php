<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->integer('pokemon_id');
            $table->string('name');
            $table->string('type');
            $table->integer('hp');
            $table->integer('attack');
            $table->integer('defense');
            $table->integer('speed');
            $table->integer('sp_atk');
            $table->integer('sp_def');
            $table->string('seed_pokemon');
            $table->float('height');
            $table->float('weight');
            $table->integer('catch_rate');
            $table->string('gender_ratio');
            $table->string('egg_groups');
            $table->integer('hatch_steps');
            $table->string('abilities');
            $table->string('evs');
            $table->string('evolution_chain');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pokemons');
    }
};