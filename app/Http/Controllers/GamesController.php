<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameExpansion;
use App\Models\GameGuest;
use App\Models\GameUser;
use App\Models\GameComment;
use App\Models\Boardgame;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Input;
use Validator;

class GamesController extends Controller
{
	public function getGames()
	{
		$player = 0;
		$boardgame = 0;
		$dateFrom = '';
		$dateTo = '';

		$player = \Request::get('player');
		$boardgame = \Request::get('boardgame');
		$dateFrom = \Request::get('dateFrom');
		$dateTo = \Request::get('dateTo');

		$filters = [
			'player' => $player,
			'boardgame' => $boardgame,
			'dateFrom' => $dateFrom,
			'dateTo' => $dateTo
		];

		$query = Game::query();
		$query->orderBy('date');

		if ($player > 0) {
			$mappings = GameUser::where('user_id', $player)->get();

			$ids = [];

			foreach ($mappings as $mapping) {
				$ids[] = $mapping->game_id;
			}

			$query->whereIn('id', $ids);
		}

		if ($boardgame > 0) {
			$query->where('boardgame_id', $boardgame);
		}

		if ($dateFrom) {
			$query->where('date', '>=', $dateFrom);
		}

		if ($dateTo) {
			$query->where('date', '<=', $dateTo);
		}

		$games = $query->get();

		$users = User::orderBy('name')->get();
		$boardgames = Boardgame::orderBy('name')->get();

		return view('games.index', array(
			'games' => $games,
			'filters' => $filters,
			'users' => $users,
			'boardgames' => $boardgames
		));
	}

	public function getGame(Game $game)
	{
		$players = [];

		foreach ($game->players as $player) {
			$players[] = $player->user_id;
		}

		return view('games.view', array(
			'game' => $game,
			'players' => $players
		));
	}

	public function getNewGame()
	{
		$boardgames = Boardgame::orderBy('name', 'asc')->get();
		$users = User::orderBy('name', 'asc')->get();

		return view('games.add', array(
			'boardgames' => $boardgames,
			'users' => $users
		));
	}

	public function postNewGame(Request $request)
	{
		$rules = array(
			'boardgame' => 'required',
			'minutes' => 'required',
			'date' => 'required',
			'description' => 'max:1063',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->saveGame(Input::all());

		return redirect('/games');
	}

	public function getEditGame(Game $game)
	{
		$boardgames = Boardgame::orderBy('name', 'asc')->get();
		$users = User::orderBy('name', 'asc')->get();

		$selected = [];

		foreach ($game->expansions as $expansion) {
			$selected[] = $expansion->id;
		}

		return view('games.edit', array(
			'game' => $game,
			'boardgames' => $boardgames,
			'expansions' => $game->boardgame->expansions,
			'users' => $users,
			'selected' => $selected
		));
	}

	public function postEditGame(Game $game, Request $request)
	{
		$rules = array(
			'boardgame' => 'required',
			'minutes' => 'required',
			'date' => 'required',
			'description' => 'max:1063',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$data = Input::all();
		$data['id'] = $game->id;

		$this->saveGame($data);

		return redirect('/games');
	}

	private function saveGame($request) {

		$loged_user = Auth::user();

		if (isset($request['id'])) {
			$game = Game::where('id', $request['id'])->first();
		} else {
			$game = new Game;
		}

		$game->boardgame_id = trim($request['boardgame']);
		$game->user_id = $loged_user->id;
		$game->date = trim($request['date']);
		$game->minutes = intval(trim($request['minutes']));
		$game->description = trim($request['description']);
		$game->short_description = trim($request['short_description']);

		$game->save();

		$oldExpansions = GameExpansion::where('game_id', $game->id)->get();

		foreach ($oldExpansions as $oldExpansion) {
			$oldExpansion->delete();
		}

		$expansions = json_decode($request['expan'], true);

		foreach ($expansions as $expansion) {
			if ($expansion['selected']) {
				$gameExpansion = new GameExpansion;
				$gameExpansion->game_id = $game->id;
				$gameExpansion->expansion_id = $expansion['id'];

				$gameExpansion->save();
			}				
		}

		$oldPlayers = GameUser::where('game_id', $game->id)->get();

		foreach ($oldPlayers as $oldPlayer) {
			$oldPlayer->delete();
		}

		$players = json_decode($request['players'], true);

		foreach ($players as $player) {
			$gamePlayer = new GameUser;
			$gamePlayer->game_id = $game->id;
			$gamePlayer->user_id = $player['id'];
			$gamePlayer->winner = $player['winner'];

			$gamePlayer->save();
		}

		$oldGuests = GameGuest::where('game_id', $game->id)->get();

		foreach ($oldGuests as $oldGuest) {
			$oldGuest->delete();
		}

		$guests = json_decode($request['gst'], true);

		foreach ($guests as $guest) {
			$gameGuest = new GameGuest;
			$gameGuest->game_id = $game->id;
			$gameGuest->name = $guest['name'];
			$gameGuest->winner = $guest['winner'];

			$gameGuest->save();
		}
	}

	public function postGameComment(Game $game, Request $request) {
		$comment = Input::get('comment');

		if (!$comment) {
			return redirect('/game/view/' . $game->id);
		}

		$loged_user = Auth::user();

		$gameComment = new GameComment;
		
		$gameComment->game_id = $game->id;
		$gameComment->user_id = $loged_user->id;
		$gameComment->comment = $comment;

		$gameComment->save();

		return redirect('/game/view/' . $game->id);
	}
}