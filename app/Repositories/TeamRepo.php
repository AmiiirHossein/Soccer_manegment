<?php

namespace App\Repositories;

use App\Helpers\UploadHelper;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Resources\Api\TeamResource;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamRepo {

//    protected $teamLeagueModel;
//
//    public function __construct(Team $teamLeagueModel)
//    {
//        $this->teamLeagueModel = $teamLeagueModel;
//    }

    public function findById($team){
        return Team::findOrfail($team);
    }

    public function getAll(){
       return TeamResource::collection();
    }

    public function create(array $data)
    {
        return Team::create($data);
    }

    public function update(int $id, array $data): ?\App\Models\Team
    {
        $team = Team::find($id);

        if (!$team) {
            return null;
        }

        $team->update($data);

        return $team;
    }

//    public function existTeam($team,$league)
//    {
//        return $team->leagues()->where('league_id',$league->id)->exists();
//    }

    public function isTeamInLeague($teamId, $leagueId): bool
    {
        return DB::table('league_team') // نام جدول واسط
        ->where('team_id', $teamId)
            ->where('league_id', $leagueId)
            ->exists();
    }

        public function assignTeamToLeague($teamId, $leagueId): void
        {
            Team::find($teamId)
                ->leagues()
                ->attach($leagueId);
        }

}
