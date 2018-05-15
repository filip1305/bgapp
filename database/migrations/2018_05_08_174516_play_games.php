<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('boardgame_id');
            $table->integer('user_id');
            $table->integer('minutes');
            $table->date('date');
            $table->string('description', 1024)->nullable();
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();

            $table->index('boardgame_id');
            $table->index('user_id');
        });

        Schema::create('game_expansions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('expansion_id');
            $table->nullableTimestamps();

            $table->index('game_id');
            $table->index('expansion_id');
        });

        Schema::create('game_comments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('user_id');
            $table->string('comment', 1024);
            $table->nullableTimestamps();

            $table->index('game_id');
            $table->index('user_id');
        });

        Schema::create('game_users', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('user_id');
            $table->tinyInteger('winner')->default(0);
            $table->nullableTimestamps();

            $table->index('game_id');
            $table->index('user_id');
        });

        Schema::create('game_guests', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('name', 128);
            $table->tinyInteger('winner')->default(0);
            $table->nullableTimestamps();

            $table->index('game_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
        Schema::drop('game_expansions');
        Schema::drop('game_comments');
        Schema::drop('game_users');
        Schema::drop('game_guests');
    }
}
