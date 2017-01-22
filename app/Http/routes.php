<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Pattern Routes
 */
Route::pattern('boardgame', '[0-9]+');

/**
 * Models binded
 */
Route::model('boardgame', 'CapTable\Models\Boardgame');

Route::get('/', function () {
    return view('welcome');
});
Route::get('boardgames', array('uses' => 'BoardgamesController@getIndex'));