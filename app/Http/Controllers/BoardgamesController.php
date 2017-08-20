<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;
use App\Models\UserBoardgame;
use Auth;
use Illuminate\Http\Request;
use Input;

class BoardgamesController extends Controller
{

	public function getBoardgames()
	{
		$name = '';
		$players = '';
		$type = 0;

		$name = \Request::get('name');
		$players = \Request::get('players');
		$type = \Request::get('type');

		$filters = [
			'name' => $name,
			'players' => $players,
			'type' => $type
		];

		$loged_user = Auth::user();

		$query = Boardgame::query();

		$query = $query->where('name','like','%'.$name.'%');
		$query = $query->orderByRaw('rank = 0 ASC, rank');

		if (!empty($players)) {
			$query = $query->where('minplayers', '<=', $players);
			$query = $query->where('maxplayers', '>=', $players);
		}

		if ($type == 1) {
			$my_bgs = UserBoardgame::where('user_id', $loged_user->id)
				->get();

			$ids = [];

			foreach ($my_bgs as $my_bs) {
				$ids[] = $my_bs->boardgame_id;
			}

			$query = $query->whereIn('id', $ids);
		}

		$boardgames = $query->get();

		return view('boardgames.index', array(
			'boardgames' => $boardgames,
			'filters' => $filters,
			'admin' => $loged_user->admin
		));
	}

	public function getNewBoardgame()
	{
		return view('boardgames.add', array());
	}

	public function postNewBoardgame(Request $request)
	{
		$boardgame = new Boardgame;
		$boardgame->name = trim(Input::get('name'));
		$boardgame->bgg_link = trim(Input::get('bgg_link'));

		$bgg_id = 0;

		if (strpos($boardgame->bgg_link, 'boardgamegeek.com/boardgame') > 0) {

			$link = str_replace("https://boardgamegeek.com/boardgame","",$boardgame->bgg_link);

			$link = substr($link, strpos($link, '/') + 1);

			$bgg_id = (int)$link;
		}

		$boardgame->bgg_id = 0;
		$boardgame->yearpublished = NULL;
		$boardgame->minplayers = NULL;
		$boardgame->maxplayers = NULL;
		$boardgame->minplaytime = NULL;
		$boardgame->maxplaytime = NULL;
		$boardgame->description = NULL;
		$boardgame->thumbnail = NULL;
		$boardgame->image = NULL;
		$boardgame->rank = 0;

		if ($bgg_id > 0) {
			$bgg_date = $this->getDataFromBGG($bgg_id);

			if (!empty($bgg_date)) {
				$boardgame->bgg_id = $bgg_id;
				$boardgame->yearpublished = $bgg_date['yearpublished'];
				$boardgame->minplayers = $bgg_date['minplayers'];
				$boardgame->maxplayers = $bgg_date['maxplayers'];
				$boardgame->minplaytime = $bgg_date['minplaytime'];
				$boardgame->maxplaytime = $bgg_date['maxplaytime'];
				$boardgame->description = $bgg_date['description'];
				$boardgame->thumbnail = $bgg_date['thumbnail'];
				$boardgame->image = $bgg_date['image'];

				if (count($bgg_date['statistics']['ratings']['ranks']['rank']) > 1) {
					$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
				} elseif (count($bgg_date['statistics']['ratings']['ranks']['rank']) == 1) {
					$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank']['@attributes']['value'];
				} else {
					$boardgame->rank = 0;
				}

				$this->validate($request, [
			        'bgg_link' => 'unique:boardgames,bgg_link',
			    ]);
			}
		}

		$boardgame->save();

		return redirect('/boardgames/');
	}

	public function getEditBoardgame(Boardgame $boardgame)
	{
		return view('boardgames.edit', array(
			'boardgame' => $boardgame
		));
	}

	public function postUpdateBoardgame(Boardgame $boardgame, Request $request)
	{
		$boardgame->name = trim(Input::get('name'));
		$boardgame->bgg_link = trim(Input::get('bgg_link'));
		
		$bgg_id = 0;

		if (strpos($boardgame->bgg_link, 'boardgamegeek.com/boardgame') > 0) {

			$link = str_replace("https://boardgamegeek.com/boardgame","",$boardgame->bgg_link);

			$link = substr($link, strpos($link, '/') + 1);

			$bgg_id = (int)$link;
		}

		$boardgame->bgg_id = 0;
		$boardgame->yearpublished = NULL;
		$boardgame->minplayers = NULL;
		$boardgame->maxplayers = NULL;
		$boardgame->minplaytime = NULL;
		$boardgame->maxplaytime = NULL;
		$boardgame->description = NULL;
		$boardgame->thumbnail = NULL;
		$boardgame->image = NULL;
		$boardgame->rank = 0;

		if ($bgg_id > 0) {
			$bgg_date = $this->getDataFromBGG($bgg_id);

			if (!empty($bgg_date)) {
				$boardgame->bgg_id = $bgg_id;
				$boardgame->yearpublished = $bgg_date['yearpublished'];
				$boardgame->minplayers = $bgg_date['minplayers'];
				$boardgame->maxplayers = $bgg_date['maxplayers'];
				$boardgame->minplaytime = $bgg_date['minplaytime'];
				$boardgame->maxplaytime = $bgg_date['maxplaytime'];
				$boardgame->description = $bgg_date['description'];
				$boardgame->thumbnail = $bgg_date['thumbnail'];
				$boardgame->image = $bgg_date['image'];
				
				if (count($bgg_date['statistics']['ratings']['ranks']['rank']) > 1) {
					$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
				} elseif (count($bgg_date['statistics']['ratings']['ranks']['rank']) == 1) {
					$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank']['@attributes']['value'];
				} else {
					$boardgame->rank = 0;
				}

				$this->validate($request, [
			        'bgg_link' => 'unique:boardgames,bgg_link,' . $boardgame->id,
			    ]);
			}
		}

		$boardgame->save();

		return redirect('/boardgames/');
	}

	public function getBoardgame(Boardgame $boardgame)
	{
		return view('boardgames.view', array(
			'boardgame' => $boardgame,
			'expansions' => $boardgame->expansions
		));
	}

	private function getDataFromBGG($id){
		$curl = curl_init();

	    curl_setopt_array($curl, array(
	        CURLOPT_URL => "https://www.boardgamegeek.com/xmlapi/boardgame/" . $id . "?stats=1",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_TIMEOUT => 5,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "GET",
	        CURLOPT_HTTPHEADER => array(
	            "cache-control: no-cache"
	        ),
	    ));

	    $response = curl_exec($curl);
	    $err = curl_error($curl);

	    curl_close($curl);

	    $xml = simplexml_load_string($response);
	    $json = json_encode($xml);
	    $array = json_decode($json,TRUE);

	    return $array['boardgame'];
	}

	public function refreshBggData(){
		$loged_user = Auth::user();

		if ($loged_user->admin != 1) {
			return redirect('/boardgames/');
		}

		$boardgames = Boardgame::get();

		foreach ($boardgames as $boardgame) {

			if ($boardgame->bgg_id > 0) {
				$bgg_date = $this->getDataFromBGG($boardgame->bgg_id);

				if (!empty($bgg_date)) {
					$boardgame->yearpublished = $bgg_date['yearpublished'];
					$boardgame->minplayers = $bgg_date['minplayers'];
					$boardgame->maxplayers = $bgg_date['maxplayers'];
					$boardgame->minplaytime = $bgg_date['minplaytime'];
					$boardgame->maxplaytime = $bgg_date['maxplaytime'];
					$boardgame->description = $bgg_date['description'];
					$boardgame->thumbnail = $bgg_date['thumbnail'];
					$boardgame->image = $bgg_date['image'];
					
					if (count($bgg_date['statistics']['ratings']['ranks']['rank']) > 1) {
						$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
					} elseif (count($bgg_date['statistics']['ratings']['ranks']['rank']) == 1) {
						$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank']['@attributes']['value'];
					} else {
						$boardgame->rank = 0;
					}
				}

				$boardgame->save();
			}

		}

	    return redirect('/boardgames/');
	}
}