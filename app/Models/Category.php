<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function boardgames()
    {
        return $this->belongsToMany('App\Models\Boardgame', 'boardgames_categories', 'category_id', 'boardgame_id');
    }

    public function expansions()
    {
        return $this->belongsToMany('App\Models\Expansion', 'expansions_categories', 'category_id', 'expansion_id');
    }
}