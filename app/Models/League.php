<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class League extends Model

{
    use Notifiable,HasFactory;
    protected $fillable = ['name', 'season', 'organizer_id', 'start_date', 'end_date'];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    public function leagueTeams()
    {
        return $this->hasMany(League::class, 'league_id');
    }

    public function fixtures()
    {
        return $this->hasMany(Fixture::class, 'league_id');
    }
    // در مدل League
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'league_team');
    }
// League.php
//    public function teams()
//    {
//        return $this->hasMany(Team::class);
//    }

    // League.php
    public function teamStats()
    {
        return $this->hasMany(LeagueTeamStat::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }


}
