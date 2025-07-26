<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\Api\TeamResource;
use App\Models\League;
use App\Models\Team;
use App\Helpers\UploadHelper;
use App\Services\TeamService;

class TeamController extends Controller
{
    public function __construct(protected TeamService $teamService) {}

    public function index()
    {
        $teams = $this->teamService->getAll();
        return TeamResource::collection($teams);
    }

    public function store(StoreTeamRequest $request)
    {
        $data = $request->only(['name', 'coach_id']);
        $file = $request->file('logo');

        $team = $this->teamService->createTeam($data, $file);
        return response()->json(['message' => 'Team created', 'team' => $team]);
    }


    public function update(UpdateTeamRequest $request, $id)
    {
        $data = $request->only(['name', 'coach_id']);
        $file = $request->file('logo');

        $team = $this->teamService->updateTeam($id, $data, $file);

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json([
            'message' => 'Team updated successfully',
            'team' => $team,
        ]);
    }


    public function assignLeague(Team $team, League $league)
    {
        $result = $this->teamService->assignTeamToLeague($team->id, $league->id);

        return response()->json([
            'message' => $result['message']
        ], $result['status']);
    }


}
