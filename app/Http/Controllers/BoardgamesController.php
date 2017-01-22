<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;

class BoardgamesController extends Controller
{

	public function getIndex()
	{
		return view('boardgames.index', array());
	}
}