<?php

namespace App\Http\Controllers;

use App\Models\Expansion;
use App\Models\Boardgame;
use App\Models\BoardgameExpansion;
use Input;

class ExpansionsController extends Controller
{

	public function getExpansions()
	{
		$search = '';
		$search = \Request::get('search');

		$expansions = Expansion::where('name','like','%'.$search.'%')
			->orderBy('name', 'asc')
			->get();

		return view('expansions.index', array(
			'expansions' => $expansions,
			'search' => $search,
		));
	}

	public function getNewExpansion()
	{
		$boardgames = Boardgame::orderBy('name', 'asc')->get();

		return view('expansions.add', array(
			'boardgames' => $boardgames
		));
	}

	public function postNewExpansion()
	{
		$expansion = new Expansion;
		$expansion->name = trim(Input::get('name'));
		$expansion->bgg_link = trim(Input::get('bgg_link'));

		$bgg_id = 0;

		if (strpos($expansion->bgg_link, 'boardgamegeek.com/boardgameexpansion') > 0) {

			$link = str_replace("https://boardgamegeek.com/boardgameexpansion","",$expansion->bgg_link);

			$link = substr($link, strpos($link, '/') + 1);

			$bgg_id = (int)$link;
		}

		$expansion->bgg_id = 0;
		$expansion->yearpublished = NULL;
		$expansion->minplayers = NULL;
		$expansion->maxplayers = NULL;
		$expansion->minplaytime = NULL;
		$expansion->maxplaytime = NULL;
		$expansion->description = NULL;
		$expansion->thumbnail = NULL;
		$expansion->image = NULL;
		$expansion->rank = NULL;

		if ($bgg_id > 0) {
			$bgg_date = $this->getDataFromBGG($bgg_id);

			if (!empty($bgg_date)) {
				$expansion->bgg_id = $bgg_id;
				$expansion->yearpublished = $bgg_date['yearpublished'];
				$expansion->minplayers = $bgg_date['minplayers'];
				$expansion->maxplayers = $bgg_date['maxplayers'];
				$expansion->minplaytime = $bgg_date['minplaytime'];
				$expansion->maxplaytime = $bgg_date['maxplaytime'];
				$expansion->description = $bgg_date['description'];
				$expansion->thumbnail = $bgg_date['thumbnail'];
				$expansion->image = $bgg_date['image'];
				$expansion->rank = 0;//$bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
			}
		}

		$expansion->save();

		foreach (Input::get('boardgames') as $boardgame_id) {
			$mapping = new BoardgameExpansion;

			$mapping->boardgame_id = $boardgame_id;
			$mapping->expansion_id = $expansion->id;

			$mapping->save();
		}

		return redirect('/expansions/');
	}

	public function getEditExpansion(Expansion $expansion)
	{
		$boardgames = Boardgame::orderBy('name', 'asc')->get();

		$selected = [];

		foreach ($expansion->boardgames as $boardgame) {
			$selected[] = $boardgame->id;
		}

		return view('expansions.edit', array(
			'expansion' => $expansion,
			'boardgames' => $boardgames,
			'selected' => $selected
		));
	}

	public function postUpdateExpansion(Expansion $expansion)
	{
		$expansion->name = trim(Input::get('name'));
		$expansion->bgg_link = trim(Input::get('bgg_link'));
		
		$bgg_id = 0;

		if (strpos($expansion->bgg_link, 'boardgamegeek.com/boardgameexpansion') > 0) {

			$link = str_replace("https://boardgamegeek.com/boardgameexpansion","",$expansion->bgg_link);

			$link = substr($link, strpos($link, '/') + 1);

			$bgg_id = (int)$link;
		}

		$expansion->bgg_id = 0;
		$expansion->yearpublished = NULL;
		$expansion->minplayers = NULL;
		$expansion->maxplayers = NULL;
		$expansion->minplaytime = NULL;
		$expansion->maxplaytime = NULL;
		$expansion->description = NULL;
		$expansion->thumbnail = NULL;
		$expansion->image = NULL;
		$expansion->rank = NULL;

		if ($bgg_id > 0) {
			$bgg_date = $this->getDataFromBGG($bgg_id);

			if (!empty($bgg_date)) {
				$expansion->bgg_id = $bgg_id;
				$expansion->yearpublished = $bgg_date['yearpublished'];
				$expansion->minplayers = $bgg_date['minplayers'];
				$expansion->maxplayers = $bgg_date['maxplayers'];
				$expansion->minplaytime = $bgg_date['minplaytime'];
				$expansion->maxplaytime = $bgg_date['maxplaytime'];
				$expansion->description = $bgg_date['description'];
				$expansion->thumbnail = $bgg_date['thumbnail'];
				$expansion->image = $bgg_date['image'];
				$expansion->rank = 0;//$bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
			}
		}

		$expansion->save();

		$selected = BoardgameExpansion::where('expansion_id', '=', $expansion->id)->get();

		foreach ($selected as $mapping) {
			$mapping->delete();
		}

		foreach (Input::get('boardgames') as $boardgame_id) {
			$mapping = new BoardgameExpansion;

			$mapping->boardgame_id = $boardgame_id;
			$mapping->expansion_id = $expansion->id;

			$mapping->save();
		}

		return redirect('/expansions/');
	}

	public function getExpansion(Expansion $expansion)
	{
		return view('expansions.view', array(
			'expansion' => $expansion
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
		$expansions = Expansion::get();

		foreach ($expansions as $expansion) {

			if ($expansion->bgg_id > 0) {
				$bgg_date = $this->getDataFromBGG($expansion->bgg_id);

				if (!empty($bgg_date)) {
					$expansion->yearpublished = $bgg_date['yearpublished'];
					$expansion->minplayers = $bgg_date['minplayers'];
					$expansion->maxplayers = $bgg_date['maxplayers'];
					$expansion->minplaytime = $bgg_date['minplaytime'];
					$expansion->maxplaytime = $bgg_date['maxplaytime'];
					$expansion->description = $bgg_date['description'];
					$expansion->thumbnail = $bgg_date['thumbnail'];
					$expansion->image = $bgg_date['image'];
					$expansion->rank = 0;//$bgg_date['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
				}

				$expansion->save();
			}

		}

	    return redirect('/expansions/');
	}
}