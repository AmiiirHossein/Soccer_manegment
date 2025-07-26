<?php

namespace App\Services;

use App\Models\League;
use App\Models\User;
use App\Notifications\LeagueApprovedNotification;
use App\Notifications\LeagueRejectedNotification;
use App\Repositories\LeagueRepo;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    protected UserRepo $userRepo;
    protected LeagueRepo $leagueRepo;

    public function __construct(UserRepo $userRepo, LeagueRepo $leagueRepo)
    {
        $this->userRepo = $userRepo;
        $this->leagueRepo = $leagueRepo;
    }

    public function listAdmins()
    {
        return $this->userRepo->getAdmins();
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->update($user, $data);
    }

    public function deleteUser(User $user): bool
    {
        return $this->userRepo->delete($user);
    }

    public function getAllLeagues()
    {
        return $this->leagueRepo->getAll();
    }

    public function approveLeague(League $league)
    {
        if ($league->status === 'approved') {
            throw new \Exception('This league is already approved.');
        }

        $this->leagueRepo->approve($league);
        $league->organizer->notify(new LeagueApprovedNotification($league));

        return $league;
    }

    public function rejectLeague(League $league)
    {
        if ($league->status === 'rejected') {
            throw new \Exception('This league is already rejected.');
        }

        $this->leagueRepo->reject($league);
        $league->organizer->notify(new LeagueRejectedNotification($league));

        return $league;
    }
}
