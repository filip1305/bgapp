<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_expansions',function ($table){
            $table->index('user_id');
            $table->index('expansion_id');
        });

        Schema::table('user_boardgames',function ($table){
            $table->index('user_id');
            $table->index('boardgame_id');
        });

        Schema::table('expansion_publishers',function ($table){
            $table->index('expansion_id');
            $table->index('publisher_id');
        });

        Schema::table('expansion_designers',function ($table){
            $table->index('expansion_id');
            $table->index('designer_id');
        });

        Schema::table('expansion_categories',function ($table){
            $table->index('expansion_id');
            $table->index('category_id');
        });

        Schema::table('boardgame_publishers',function ($table){
            $table->index('boardgame_id');
            $table->index('publisher_id');
        });

        Schema::table('boardgame_designers',function ($table){
            $table->index('boardgame_id');
            $table->index('designer_id');
        });

        Schema::table('boardgame_categories',function ($table){
            $table->index('boardgame_id');
            $table->index('category_id');
        });

        Schema::table('boardgame_expansions',function ($table){
            $table->index('boardgame_id');
            $table->index('expansion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_expansions',function ($table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['expansion_id']);
        });

        Schema::table('user_boardgames',function ($table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['boardgame_id']);
        });

        Schema::table('expansion_publishers',function ($table){
            $table->dropIndex(['expansion_id']);
            $table->dropIndex(['publisher_id']);
        });

        Schema::table('expansion_designers',function ($table){
            $table->dropIndex(['expansion_id']);
            $table->dropIndex(['designer_id']);
        });

        Schema::table('expansion_categories',function ($table){
            $table->dropIndex(['expansion_id']);
            $table->dropIndex(['category_id']);
        });

        Schema::table('boardgame_publishers',function ($table){
            $table->dropIndex(['boardgame_id']);
            $table->dropIndex(['publisher_id']);
        });

        Schema::table('boardgame_designers',function ($table){
            $table->dropIndex(['boardgame_id']);
            $table->dropIndex(['designer_id']);
        });

        Schema::table('boardgame_categories',function ($table){
            $table->dropIndex(['boardgame_id']);
            $table->dropIndex(['category_id']);
        });

        Schema::table('boardgame_expansions',function ($table){
            $table->dropIndex(['boardgame_id']);
            $table->dropIndex(['expansion_id']);
        });
    }
}
