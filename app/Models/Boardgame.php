<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}