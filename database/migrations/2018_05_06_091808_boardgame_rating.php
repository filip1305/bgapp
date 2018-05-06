<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BoardgameRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardgame_ratings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('boardgame_id');
            $table->integer('user_id');
            $table->integer('rating');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
            $table->index('boardgame_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('boardgame_ratings');
    }
}
