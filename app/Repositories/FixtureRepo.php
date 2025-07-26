<?php

namespace App\Repositories;

use App\Models\Fixture;
use App\Models\League;

class FixtureRepo
{
    public function getFixturesByLeague(League $league)
    {
        return Fixture::with(['homeTeam', 'awayTeam'])
            ->where('league_id', $league->id)
            ->orderBy('match_date')
            ->get();
    }

    public function save(Fixture $fixture): Fixture
    {
        $fixture->save();
        return $fixture;
    }
}
