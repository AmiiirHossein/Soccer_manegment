<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTeamStat extends Model
{
    protected $table = 'league_team_stats';
    protected $fillable = ['team_id','league_id','won','draw','lost','goals_for','goals_against','points'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
