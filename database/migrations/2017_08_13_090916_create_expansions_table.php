<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpansionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expansions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('bgg_link', 511);
            $table->integer('bgg_id')->nullable();
            $table->integer('yearpublished')->nullable();
            $table->integer('minplayers')->nullable();
            $table->integer('maxplayers')->nullable();
            $table->integer('minplaytime')->nullable();
            $table->integer('maxplaytime')->nullable();
            $table->integer('rank')->nullable();
            $table->string('description', 2047)->nullable();
            $table->string('thumbnail', 127)->nullable();
            $table->string('image', 127)->nullable();
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('boardgame_expansions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('boardgame_id');
            $table->integer('expansion_id');
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
        Schema::drop('expansions');
        Schema::drop('boardgame_expansions');
    }
}
