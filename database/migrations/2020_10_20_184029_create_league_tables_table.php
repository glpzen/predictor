<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('team_id');
            $table->integer('week');
            $table->integer('points');
            $table->integer('played');
            $table->integer('won');
            $table->integer('drawn');
            $table->integer('lost');
            $table->integer('goals_difference');
            $table->integer('opposing_team');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('league_tables');
    }
}
