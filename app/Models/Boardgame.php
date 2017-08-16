<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boardgame extends Model
{
	public function expansions()
    {
        return $this->belongsToMany('App\Models\Expansion', 'boardgame_expansions', 'boardgame_id', 'expansion_id');
    }
}