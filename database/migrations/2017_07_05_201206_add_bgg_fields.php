<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBggFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boardgames',function ($table){
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boardgames',function ($table){
            $table->dropColumn('bgg_id');
            $table->dropColumn('yearpublished');
            $table->dropColumn('minplayers');
            $table->dropColumn('maxplayers');
            $table->dropColumn('minplaytime');
            $table->dropColumn('maxplaytime');
            $table->dropColumn('rank');
            $table->dropColumn('description');
            $table->dropColumn('thumbnail');
            $table->dropColumn('image');
        });
    }
}
