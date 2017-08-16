<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expansion extends Model
{
	public function boardgames()
    {
        return $this->belongsToMany('App\Models\Boardgame', 'boardgame_expansions', 'expansion_id', 'boardgame_id');
    }
}