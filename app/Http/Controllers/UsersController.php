<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;
use App\Models\Expansion;
use App\Models\UserBoardgame;
use App\Models\UserExpansion;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Input;

class UsersController extends Controller
{

	public function getUsers()
	{
		$search = '';
		$search = \Request::get('search');

		$users = User::where('name','like','%'.$search.'%')
			->orderBy('name', 'asc')
			->get();

		return view('users.index', array(
			'users' => $users,
			'search' => $search,
		));
	}

	public function getUser(User $user)
	{
		$loged_user = Auth::user();

		$me = 0;

		if ($loged_user->id == $user->id) {
			$me = 1;
		}

		return view('users.view', array(
			'user' => $user,
			'me' => $me
		));
	}

	public function getDeleteBoardgame(Boardgame $boardgame)
	{
		$loged_user = Auth::user();

		$user_boardgame = UserBoardgame::where('user_id', $loged_user->id)
			->where('boardgame_id', $boardgame->id)
			->first();

		if (!empty($user_boardgame)){
			$user_boardgame->delete();
		}

		return redirect('/user/view/' . $loged_user->id);
	}

	public function getDeleteExpansion(Expansion $expansion)
	{
		$loged_user = Auth::user();

		$user_expansion = UserExpansion::where('user_id', $loged_user->id)
			->where('expansion_id', $expansion->id)
			->first();

		if (!empty($user_expansion)){
			$user_expansion->delete();
		}

		return redirect('/user/view/' . $loged_user->id);
	}

	public function getNewBoardgame()
	{
		$loged_user = Auth::user();

		$ids = [];

		foreach ($loged_user->boardgames as $boardgame) {
			$ids[] = $boardgame->id;
		}

		$boardgames = Boardgame::whereNotIn('id', $ids)
			->orderBy('name', 'asc')
			->get();		

		return view('users.add_boardgame', array(
			'boardgames' => $boardgames,
			'user' => $loged_user
		));
	}

	public function postNewBoardgame()
	{
		$loged_user = Auth::user();
		$mapping = new UserBoardgame;

		$mapping->boardgame_id = Input::get('boardgame');
		$mapping->user_id = $loged_user->id;

		$mapping->save();

		return redirect('/user/view/' . $loged_user->id);
	}

	public function getNewExpansion()
	{
		$loged_user = Auth::user();

		$ids = [];

		foreach ($loged_user->expansions as $expansion) {
			$ids[] = $expansion->id;
		}

		$expansions = Expansion::whereNotIn('id', $ids)
			->orderBy('name', 'asc')
			->get();		

		return view('users.add_expansion', array(
			'expansions' => $expansions,
			'user' => $loged_user
		));
	}

	public function postNewExpansion()
	{
		$loged_user = Auth::user();
		$mapping = new UserExpansion;

		$mapping->expansion_id = Input::get('expansion');
		$mapping->user_id = $loged_user->id;

		$mapping->save();

		return redirect('/user/view/' . $loged_user->id);
	}

	public function getMyProfile()
	{
		$loged_user = Auth::user();
		return redirect('/user/view/' . $loged_user->id);
	}

	public function getChangePass()
	{
		return view('users.change_password', array());
	}

	public function postChangePass(Request $request)
	{
		$loged_user = Auth::user();

		$this->validate($request, [
	        'new_password' => 'required|confirmed|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
	    ]);

		if ((Hash::check(Input::get('old_password'), $loged_user->password)) && (Input::get('new_password') == Input::get('password_confirmation'))) {
		    $loged_user->password = bcrypt(Input::get('new_password'));

		    $loged_user->save();
		} else {
			return view('users.change_password', array());
		}

		return redirect('/user/view/' . $loged_user->id);
	}
}