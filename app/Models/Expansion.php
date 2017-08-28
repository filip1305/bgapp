<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expansion extends Model
{
	public function boardgames()
    {
        return $this->belongsToMany('App\Models\Boardgame', 'boardgame_expansions', 'expansion_id', 'boardgame_id');
    }

    public function designers()
    {
        return $this->belongsToMany('App\Models\Designer', 'expansion_designers', 'expansion_id', 'designer_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'expansion_categories', 'expansion_id', 'category_id');
    }

    public function publishers()
    {
        return $this->belongsToMany('App\Models\Publisher', 'expansion_publishers', 'expansion_id', 'publisher_id');
    }
}