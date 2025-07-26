<?php

namespace App\Services;

use App\Models\League;
use App\Repositories\StandRepo;

class StandingService
{
    protected StandRepo $standRepo;

    public function __construct(StandRepo $standRepo)
    {
        $this->standRepo = $standRepo;
    }

    public function getLeagueStandings(League $league)
    {
        return $this->standRepo->getStandingsForLeague($league);
    }
}
