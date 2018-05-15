<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameGuest extends Model
{
    public function game()
    {
        return $this->belongsTo('App\Model\Game');
    }
}