<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BoardgameRating;
use Auth;

class Boardgame extends Model
{
	public function expansions()
    {
        return $this->belongsToMany('App\Models\Expansion', 'boardgame_expansions', 'boardgame_id', 'expansion_id');
    }

    public function designers()
    {
        return $this->belongsToMany('App\Models\Designer', 'boardgame_designers', 'boardgame_id', 'designer_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'boardgame_categories', 'boardgame_id', 'category_id');
    }

    public function publishers()
    {
        return $this->belongsToMany('App\Models\Publisher', 'boardgame_publishers', 'boardgame_id', 'publisher_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_boardgames', 'boardgame_id', 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\BoardgameRating');
    }

    public function avgRating() {
        return $this->ratings()->avg('rating');
    }

    public function myRating() {
        $loged_user = Auth::user();

        $boardgameRating = BoardgameRating::where('boardgame_id', $this->id)
            ->where('user_id', $loged_user->id)
            ->first();

        if ($boardgameRating) {
            return $boardgameRating->rating;
        }

        return NULL;
    }
}