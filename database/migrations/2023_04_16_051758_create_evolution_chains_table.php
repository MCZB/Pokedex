<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvolutionChainsTable extends Migration
{
    public function up()
    {
        Schema::create('evolution_chains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pokemon_id');
            $table->unsignedBigInteger('evolves_from')->nullable();
            $table->unsignedBigInteger('evolves_to')->nullable();
            $table->timestamps();

            $table->foreign('pokemon_id')->references('id')->on('pokemon')->onDelete('cascade');
            $table->foreign('evolves_from')->references('id')->on('pokemon')->onDelete('set null');
            $table->foreign('evolves_to')->references('id')->on('pokemon')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evolution_chains');
    }
}
