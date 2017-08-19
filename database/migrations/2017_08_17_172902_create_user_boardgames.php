<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBoardgames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_expansions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('expansion_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('user_boardgames', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('boardgame_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_expansions');
        Schema::drop('user_boardgames');
    }
}
