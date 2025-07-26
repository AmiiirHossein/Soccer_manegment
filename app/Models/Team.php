<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ["name","logo","coach_id"];

    public function user()
    {
        $this->belongsTo(User::class);
    }
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function leagueTeams()
    {
        return $this->hasMany(League::class, 'team_id');
    }

    public function homeFixture()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayFixture()
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }

    public function leagues()
    {
        return $this->belongsToMany(League::class, 'league_team');
    }
    public function leagueStats()
    {
        return $this->hasMany(LeagueTeamStat::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

}
