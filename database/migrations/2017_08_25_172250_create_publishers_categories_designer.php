<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishersCategoriesDesigner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 127)->nullable();
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 127)->nullable();
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('boardgame_publishers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('publisher_id');
            $table->integer('boardgame_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('boardgame_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('boardgame_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('expansion_publishers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('publisher_id');
            $table->integer('expansion_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('expansion_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('expansion_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('designers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 127)->nullable();
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('boardgame_designers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('designer_id');
            $table->integer('boardgame_id');
            $table->nullableTimestamps();
            $table->datetime('deleted_at')->nullable();
        });

        Schema::create('expansion_designers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('designer_id');
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
        Schema::drop('publishers');
        Schema::drop('categories');
        Schema::drop('designers');
        Schema::drop('boardgame_publishers');
        Schema::drop('boardgame_categories');
        Schema::drop('boardgame_designers');
        Schema::drop('expansion_publishers');
        Schema::drop('expansion_categories');
        Schema::drop('expansion_designers');
    }
}
