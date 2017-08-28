<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
	public function boardgames()
    {
        return $this->belongsToMany('App\Models\Boardgame', 'boardgames_publishers', 'publisher_id', 'boardgame_id');
    }

    public function expansions()
    {
        return $this->belongsToMany('App\Models\Expansion', 'boardgames_expansions', 'publisher_id', 'expansion_id');
    }
}