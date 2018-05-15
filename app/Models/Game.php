<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
	public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function boardgame()
    {
        return $this->belongsTo('App\Models\Boardgame');
    }

    public function expansions()
    {
        return $this->belongsToMany('App\Models\Expansion', 'game_expansions', 'game_id', 'expansion_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\GameComment')->orderBy('created_at', 'desc');
    }

    public function players()
    {
        return $this->hasMany('App\Models\GameUser');
    }

    public function guests()
    {
        return $this->hasMany('App\Models\GameGuest');
    }
}