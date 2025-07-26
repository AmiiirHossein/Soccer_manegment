<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function fixture()
    {
        return $this->belongsTo(Fixture::class, 'fixture_id');
    }
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
}
