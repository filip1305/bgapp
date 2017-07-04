<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;
use Input;

class BoardgamesController extends Controller
{

	public function getBoardgames()
	{
		$boardgames = Boardgame::orderBy('name', 'asc')->get();

		return view('boardgames.index', array(
			'boardgames' => $boardgames
		));
	}

	public function getNewBoardgame()
	{
		return view('boardgames.add', array());
	}

	public function postNewBoardgame()
	{
		$boardgame = new Boardgame;
		$boardgame->name = Input::get('name');
		$boardgame->bgg_link = Input::get('bgg_link');
		$boardgame->save();

		return redirect('/boardgames/');
	}

	public function getEditBoardgame(Boardgame $boardgame)
	{
		return view('boardgames.edit', array(
			'boardgame' => $boardgame
		));
	}

	public function postUpdateBoardgame(Boardgame $boardgame)
	{
		$boardgame->name = Input::get('name');
		$boardgame->bgg_link = Input::get('bgg_link');
		$boardgame->save();

		return redirect('/boardgames/');
	}
}