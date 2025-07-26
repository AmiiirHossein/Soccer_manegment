<?php

namespace App\Repositories;

use App\Models\League;

class LeagueRepo
{
    public function all()
    {
        return League::all();
    }

    public function find(int $id): ?League
    {
        return League::find($id);
    }

    public function create(array $data): League
    {
        return League::create($data);
    }

    public function update(League $league, array $data): bool
    {
        return $league->update($data);
    }

    public function delete(League $league): bool
    {
        return $league->delete();
    }
    public function getAll()
    {
        return League::all();
    }

    public function approve(League $league): League
    {
        $league->status = 'approved';
        $league->save();
        return $league;
    }

    public function reject(League $league): League
    {
        $league->status = 'rejected';
        $league->save();
        return $league;
    }
}
