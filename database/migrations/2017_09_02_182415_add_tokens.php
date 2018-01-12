<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function ($table){
            $table->tinyInteger('active')->default(0);
            $table->string('activation_code', 127)->nullable();
            $table->string('reset_password_code', 127)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function ($table){
            $table->dropColumn('active');
            $table->dropColumn('activation_code');
            $table->dropColumn('reset_password_code');
        });
    }
}
