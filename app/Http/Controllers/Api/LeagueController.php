<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Resources\Api\LeagueResource;
use App\Models\League;
use App\Services\LeagueService;



class LeagueController extends Controller
{
    protected LeagueService $leagueService;

    public function __construct(LeagueService $leagueService)
    {
        $this->leagueService = $leagueService;
    }

    public function index(League $league)
    {
        [$teams, $numTeams] = $this->leagueService->getLeagueTeamsWithCount($league);
        return response()->json([$teams, $numTeams]);
    }

    public function store(StoreLeagueRequest $request)
    {
        $league = $this->leagueService->createLeague($request->validated());
        return response()->json(["message" => "league created", "league" => $league]);
    }

    public function update(StoreLeagueRequest $request, League $league)
    {
        $updatedLeague = $this->leagueService->updateLeague($league, $request->validated());
        return response()->json(["message" => "League updated", "league" => $updatedLeague]);
    }

    public function delete(League $league)
    {
        $this->leagueService->deleteLeague($league);
        return response()->json(["message" => "League deleted", "league" => $league]);
    }


}
