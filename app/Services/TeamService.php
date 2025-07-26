<?php

namespace App\Services;

use App\Helpers\UploadHelper;
use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Repositories\TeamRepo;

class TeamService {

    protected TeamRepo $teamRepo;

    public function __construct(TeamRepo $teamRepo) {
        $this->teamRepo = $teamRepo;
    }

    public function getAll()
    {
        return $this->teamRepo->getAll();
    }

    public function createTeam(array $data, $file = null)
    {
        if ($file) {
            $filename = UploadHelper::upload('logo', $file, 'team_logo_' . time(), public_path('uploads'));
            $data['logo'] = $filename;
        }

        return $this->teamRepo->create($data);

    }

    public function updateTeam(int $id, array $data, $file = null)
    {
        if ($file) {
            $filename = \App\Helpers\UploadHelper::upload(
                'logo',
                $file,
                'team_logo_' . time(),
                public_path('uploads')
            );
            $data['logo'] = $filename;
        }

        return $this->teamRepo->update($id, $data);
    }

//    public function assignTeamToLeague($team,$league)
//    {
//        if ($this->teamRepo->existTeam($team,$league)) {
//            return response()->json(['message' => 'Team is already assigned to this league.'], 400);
//        }
//
//       return  $team->leagues()->attach($league->id);
//    }

    public function assignTeamToLeague($teamId, $leagueId): array
    {
        if ($this->teamRepo->isTeamInLeague($teamId, $leagueId)) {
            return [
                'success' => false,
                'message' => 'Team is already assigned to this league.',
                'status' => 400
            ];
        }

        $this->teamRepo->assignTeamToLeague($teamId, $leagueId);

        return [
            'success' => true,
            'message' => 'League assigned to team successfully.',
            'status' => 200
        ];
    }
// Todo check alerady exists in assign team to league

// Todo we can seprate teamleaguerepo with teamrepo
}
