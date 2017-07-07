<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;
use Input;

class BoardgamesController extends Controller
{

	public function getBoardgames()
	{
		$boardgames = Boardgame::orderBy('rank', 'asc')->get();

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
		$boardgame->rank = NULL;

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
				$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
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

	public function postUpdateBoardgame(Boardgame $boardgame)
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
		$boardgame->rank = NULL;

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
				$boardgame->rank = $bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
			}
		}

		$boardgame->save();

		return redirect('/boardgames/');
	}

	public function getBoardgame(Boardgame $boardgame)
	{
		return view('boardgames.view', array(
			'boardgame' => $boardgame
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
}