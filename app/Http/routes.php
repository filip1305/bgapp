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
Route::pattern('expansion', '[0-9]+');
Route::pattern('user', '[0-9]+');

/**
 * Models binded
 */
Route::model('boardgame', 'App\Models\Boardgame');
Route::model('expansion', 'App\Models\Expansion');
Route::model('user', 'App\User');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', function () {
		return redirect('/boardgames/');
	    //return view('welcome');
	});


	// Boardgames
	Route::get('boardgames', 'BoardgamesController@getBoardgames');
	Route::get('boardgame/add', 'BoardgamesController@getNewBoardgame');
	Route::get('boardgame/edit/{boardgame}', 'BoardgamesController@getEditBoardgame');
	Route::get('boardgame/view/{boardgame}', 'BoardgamesController@getBoardgame');
	Route::get('boardgame/refresh', 'BoardgamesController@refreshBggData');
	
	Route::post('boardgame/add', 'BoardgamesController@postNewBoardgame');
	Route::post('boardgame/edit/{boardgame}', 'BoardgamesController@postUpdateBoardgame');

	// Expansions
	Route::get('expansions', 'ExpansionsController@getExpansions');
	Route::get('expansion/add', 'ExpansionsController@getNewExpansion');
	Route::get('expansion/edit/{expansion}', 'ExpansionsController@getEditExpansion');
	Route::get('expansion/view/{expansion}', 'ExpansionsController@getExpansion');
	Route::get('expansion/refresh', 'ExpansionsController@refreshBggData');

	Route::post('expansion/add', 'ExpansionsController@postNewExpansion');
	Route::post('expansion/edit/{expansion}', 'ExpansionsController@postUpdateExpansion');

	// Users
	Route::get('users', 'UsersController@getUsers');
	Route::get('user/view/{user}', 'UsersController@getUser');
	Route::get('user/view_me', 'UsersController@getMyProfile');

	// User boardgames
	Route::get('user/boardgame/add', 'UsersController@getNewBoardgame');
	Route::post('user/boardgame/add', 'UsersController@postNewBoardgame');
	Route::get('user/boardgame/delete/{boardgame}', 'UsersController@getDeleteBoardgame');

	Route::get('user/password', 'UsersController@getChangePass');
	Route::post('user/password', 'UsersController@postChangePass');

	// User expansions
	Route::get('user/expansion/add', 'UsersController@getNewExpansion');
	Route::post('user/expansion/add', 'UsersController@postNewExpansion');
	Route::get('user/expansion/delete/{expansion}', 'UsersController@getDeleteExpansion');

});