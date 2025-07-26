<?php

namespace App\Services;

use App\Models\League;
use App\Models\User;
use App\Notifications\NewLeagueCreated;
use App\Repositories\LeagueRepo;

class LeagueService
{
    protected LeagueService $leagueService;

    public function __construct(LeagueRepo $leagueRepo)
    {
        $this->leagueRepository = $leagueRepo;
    }

    public function getLeagueTeamsWithCount(League $league): array
    {
        $teams = $league->teams;
        $numTeams = $teams->count();
        return [$teams, $numTeams];
    }

    public function createLeague(array $data): League
    {
        $league = $this->leagueRepository->create($data);

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewLeagueCreated($league));
        }

        return $league;
    }

    public function updateLeague(League $league, array $data): League
    {
        $this->leagueRepository->update($league, $data);
        return $league;
    }

    public function deleteLeague(League $league): bool
    {
        return $this->leagueRepository->delete($league);
    }
}
