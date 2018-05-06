<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;
use App\Models\BoardgameCategory;
use App\Models\BoardgameDesigner;
use App\Models\BoardgamePublisher;
use App\Models\BoardgameRating;
use App\Models\Category;
use App\Models\Designer;
use App\Models\Publisher;
use App\Models\UserBoardgame;
use Auth;
use Illuminate\Http\Request;
use Input;
use Mail;

class BoardgamesController extends Controller
{

	public function getBoardgames()
	{
		$name = '';
		$players = '';
		$type = 0;
		$year = '';
		$category = 0;
		$publisher = 0;

		$name = \Request::get('name');
		$players = \Request::get('players');
		$type = \Request::get('type');
		$year = \Request::get('year');
		$category = \Request::get('category');
		$publisher = \Request::get('publisher');

		$filters = [
			'name' => $name,
			'players' => $players,
			'type' => $type,
			'year' => $year,
			'category' => $category,
			'publisher' => $publisher
		];
/*
		Mail::send('emails.test', [], function ($m) use ($name) {
            $m->to('filipb1986@gmail.com', 'Filip')->subject('Test');
        });
*/
		$loged_user = Auth::user();

		$query = Boardgame::query();

		$query = $query->where('name','like','%'.$name.'%');
		$query = $query->orderByRaw('rank = 0 ASC, rank');

		if (!empty($players)) {
			$query = $query->where('minplayers', '<=', $players);
			$query = $query->where('maxplayers', '>=', $players);
		}

		if (!empty($year)) {
			$query = $query->where('yearpublished', $year);
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

		if ($category > 0) {
			$mappings = BoardgameCategory::where('category_id', $category)
				->get();

			$ids = [];

			foreach ($mappings as $mapping) {
				$ids[] = $mapping->boardgame_id;
			}

			$query = $query->whereIn('id', $ids);
		}

		if ($publisher > 0) {
			$mappings = BoardgamePublisher::where('publisher_id', $publisher)
				->get();

			$ids = [];

			foreach ($mappings as $mapping) {
				$ids[] = $mapping->boardgame_id;
			}

			$query = $query->whereIn('id', $ids);
		}

		$boardgames = $query->get();

		$publishers = Publisher::orderBy('name')->get();
		$categories = Category::orderBy('name')->get();

		return view('boardgames.index', array(
			'boardgames' => $boardgames,
			'filters' => $filters,
			'admin' => $loged_user->admin,
			'publishers' => $publishers,
			'categories' => $categories
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

		$this->clearBggData($boardgame);

		$publishers = [];
		$categories = [];
		$designers = [];

		if ($bgg_id > 0) {
			$bgg_data = $this->getDataFromBGG($bgg_id);

			$boardgame->bgg_id = $bgg_id;

			if (!empty($bgg_data)) {

				$this->setBggData($boardgame, $bgg_data);

				if (!empty($bgg_data['boardgamedesigner'])){
					$designers = $bgg_data['boardgamedesigner'];
				}
				
				if (!empty($bgg_data['boardgamepublisher'])){
					$publishers = $bgg_data['boardgamepublisher'];
				}

				if (!empty($bgg_data['boardgamecategory'])){
					$categories = $bgg_data['boardgamecategory'];
				}

				$this->validate($request, [
			        'bgg_link' => 'unique:boardgames,bgg_link',
			    ]);
			}
		}

		$boardgame->save();

		$this->saveDesignerMappings($boardgame, $designers);
		$this->saveCategoryMappings($boardgame, $categories);
		$this->savePublisherMappings($boardgame, $publishers);

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

		$this->clearBggData($boardgame);

		$publishers = [];
		$categories = [];
		$designers = [];

		$this->removeMappings($boardgame);

		if ($bgg_id > 0) {
			$bgg_data = $this->getDataFromBGG($bgg_id);

			$boardgame->bgg_id = $bgg_id;

			if (!empty($bgg_data)) {

				$this->setBggData($boardgame, $bgg_data);

				if (!empty($bgg_data['boardgamedesigner'])){
					$designers = $bgg_data['boardgamedesigner'];
				}
				
				if (!empty($bgg_data['boardgamepublisher'])){
					$publishers = $bgg_data['boardgamepublisher'];
				}

				if (!empty($bgg_data['boardgamecategory'])){
					$categories = $bgg_data['boardgamecategory'];
				}

				$this->validate($request, [
			        'bgg_link' => 'unique:boardgames,bgg_link,' . $boardgame->id,
			    ]);
			}
		}

		$boardgame->save();

		$this->saveDesignerMappings($boardgame, $designers);
		$this->saveCategoryMappings($boardgame, $categories);
		$this->savePublisherMappings($boardgame, $publishers);

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
				$bgg_data = $this->getDataFromBGG($boardgame->bgg_id);

				$publishers = [];
				$categories = [];
				$designers = [];

				$this->removeMappings($boardgame);

				if (!empty($bgg_data)) {
					$this->setBggData($boardgame, $bgg_data);

					if (!empty($bgg_data['boardgamedesigner'])){
						$designers = $bgg_data['boardgamedesigner'];
					}
					
					if (!empty($bgg_data['boardgamepublisher'])){
						$publishers = $bgg_data['boardgamepublisher'];
					}

					if (!empty($bgg_data['boardgamecategory'])){
						$categories = $bgg_data['boardgamecategory'];
					}
				}

				$boardgame->save();

				$this->saveDesignerMappings($boardgame, $designers);
				$this->saveCategoryMappings($boardgame, $categories);
				$this->savePublisherMappings($boardgame, $publishers);
			}

		}

	    return redirect('/boardgames/');
	}

	private function clearBggData(&$boardgame) {
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
	}

	private function setBggData(&$boardgame, $bgg_data) {
		$boardgame->yearpublished = $bgg_data['yearpublished'];
		$boardgame->minplayers = $bgg_data['minplayers'];
		$boardgame->maxplayers = $bgg_data['maxplayers'];
		$boardgame->minplaytime = $bgg_data['minplaytime'];
		$boardgame->maxplaytime = $bgg_data['maxplaytime'];
		$boardgame->description = $bgg_data['description'];
		$boardgame->thumbnail = $bgg_data['thumbnail'];
		$boardgame->image = $bgg_data['image'];
		
		if (count($bgg_data['statistics']['ratings']['ranks']['rank']) > 1) {
			$boardgame->rank = $bgg_data['statistics']['ratings']['ranks']['rank'][0]['@attributes']['value'];
		} elseif (count($bgg_data['statistics']['ratings']['ranks']['rank']) == 1) {
			$boardgame->rank = $bgg_data['statistics']['ratings']['ranks']['rank']['@attributes']['value'];
		} else {
			$boardgame->rank = 0;
		}
	}

	private function saveCategoryMappings(Boardgame $boardgame, $categories) {
		if (!is_array($categories)) {
			$categories = [$categories];
		}

		foreach ($categories as $category_name) {
			$category = Category::where('name', $category_name)
				->first();

			if (count($category) == 0) {
				$category = new Category;

				$category->name = $category_name;

				$category->save();
			}

			$mapping = new BoardgameCategory;

			$mapping->boardgame_id = $boardgame->id;
			$mapping->category_id = $category->id;

			$mapping->save();
		}
	}

	private function savePublisherMappings(Boardgame $boardgame, $publishers) {
		if (!is_array($publishers)) {
			$publishers = [$publishers];
		}

		foreach ($publishers as $publisher_name) {
			$publisher = Publisher::where('name', $publisher_name)
				->first();

			if (count($publisher) == 0) {
				$publisher = new Publisher;

				$publisher->name = $publisher_name;

				$publisher->save();
			}

			$mapping = new BoardgamePublisher;

			$mapping->boardgame_id = $boardgame->id;
			$mapping->publisher_id = $publisher->id;

			$mapping->save();
		}
	}

	private function saveDesignerMappings(Boardgame $boardgame, $designers) {
		if (!is_array($designers)) {
			$designers = [$designers];
		}

		foreach ($designers as $designer_name) {
			$designer = Designer::where('name', $designer_name)
				->first();

			if (count($designer) == 0) {
				$designer = new Designer;

				$designer->name = $designer_name;

				$designer->save();
			}

			$mapping = new BoardgameDesigner;

			$mapping->boardgame_id = $boardgame->id;
			$mapping->designer_id = $designer->id;

			$mapping->save();
		}
	}

	private function removeMappings(Boardgame $boardgame) {
		$bg_categories = BoardgameCategory::where('boardgame_id', $boardgame->id)
			->get();

		foreach ($bg_categories as $bg_categorie) {
			$bg_categorie->delete();
		}

		$bg_publishers = BoardgamePublisher::where('boardgame_id', $boardgame->id)
			->get();

		foreach ($bg_publishers as $bg_publisher) {
			$bg_publisher->delete();
		}

		$bg_desigers = BoardgameDesigner::where('boardgame_id', $boardgame->id)
			->get();

		foreach ($bg_desigers as $bg_desiger) {
			$bg_desiger->delete();
		}
	}

	public function rateBg(Boardgame $boardgame, Request $request) {
		$rating = Input::get('rating');

		$loged_user = Auth::user();

		$boardgameRating = BoardgameRating::where('boardgame_id', $boardgame->id)
			->where('user_id', $loged_user->id)
			->first();

		if (!$boardgameRating) {
			$boardgameRating = new BoardgameRating;
		}
		
		$boardgameRating->boardgame_id = $boardgame->id;
		$boardgameRating->user_id = $loged_user->id;
		$boardgameRating->rating = $rating;

		$boardgameRating->save();

		return redirect('/boardgame/view/' . $boardgame->id);
	}
}