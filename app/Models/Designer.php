<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
	public function boardgames()
    {
        return $this->belongsToMany('App\Models\Boardgame', 'boardgames_desingers', 'desinger_id', 'boardgame_id');
    }

    public function expansions()
    {
        return $this->belongsToMany('App\Models\Expansion', 'boardgames_desingers', 'desinger_id', 'expansion_id');
    }
}