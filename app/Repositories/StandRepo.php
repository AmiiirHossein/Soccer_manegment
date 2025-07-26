<?php

namespace App\Repositories;

use App\Models\League;

class StandRepo
{

    public function getStandingsForLeague(League $league)
    {
        return $league->standings()
            ->with('team')
            ->orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for')
            ->get();

    }

}
