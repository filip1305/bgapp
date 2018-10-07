<?php

namespace App\Http\Controllers;

use App\Models\Boardgame;
use App\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function getStatistics()
    {
        $userId = 0;
        $boardgameId = 0;

        $userId = \Request::get('userId');
        $boardgameId = \Request::get('boardgameId');

        $filters = [
            'userId' => $userId,
            'boardgameId' => $boardgameId
        ];

        $allUsersData = DB::table('users')
            ->select(DB::raw('users.id, users.name, round(sum(game_users.winner) / count(*) * 100) as percent'))
            ->join('game_users', 'game_users.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('count(*) >= 10')
            ->orderBy('percent', 'DESC')
            ->get();

        $userData = DB::table('boardgames')
            ->select(DB::raw('boardgames.id, boardgames.name, round(sum(game_users.winner) / count(*) * 100) as percent'))
            ->join('games', 'boardgames.id', '=', 'games.boardgame_id')
            ->join('game_users', 'game_users.game_id', '=', 'games.id')
            ->where('game_users.user_id', $userId)
            ->groupBy('boardgames.id', 'boardgames.name')
            ->havingRaw('count(*) >= 2')
            ->orderBy('percent', 'DESC')
            ->get();

        $boardgamesData = DB::table('boardgames')
            ->select(DB::raw('boardgames.id, boardgames.name, count(*) as count, sum(games.minutes) as minutes, round(sum(games.minutes) / count(*)) as avg'))
            ->join('games', 'boardgames.id', '=', 'games.boardgame_id')
            ->groupBy('boardgames.id', 'boardgames.name')
            ->orderBy('minutes', 'DESC')
            ->get();

        $bestByBoardgameData = DB::table('users')
            ->select(DB::raw('users.id, users.name, round(sum(game_users.winner) / count(*) * 100) as percent'))
            ->join('game_users', 'game_users.user_id', '=', 'users.id')
            ->join('games', 'games.id', '=', 'game_users.game_id')
            ->where('games.boardgame_id', $boardgameId)
            ->groupBy('users.id', 'users.name')
            ->havingRaw('count(*) >= 2')
            ->orderBy('percent', 'DESC')
            ->get();

        $boardgames = Boardgame::orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('statistics.statistics', array(
            'filters' => $filters,
            'allUsersData' => $allUsersData,
            'userData' => $userData,
            'boardgamesData' => $boardgamesData,
            'bestByBoardgameData' => $bestByBoardgameData,
            'boardgames' => $boardgames,
            'users' => $users
        ));
    }
}
