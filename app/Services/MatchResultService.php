<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Standing;

class MatchResultService
{
    public function processMatch(Fixture $fixture): void
    {
        $homeTeamId = $fixture->home_team_id;
        $awayTeamId = $fixture->away_team_id;

        $homeStanding = Standing::firstOrCreate([
            'league_id' => $fixture->league_id,
            'team_id' => $homeTeamId,
        ], [
            'played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'goal_difference' => 0,
            'points' => 0,
        ]);

        $awayStanding = Standing::firstOrCreate([
            'league_id' => $fixture->league_id,
            'team_id' => $awayTeamId,
        ], [
            'played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'goal_difference' => 0,
            'points' => 0,
        ]);

        // افزایش تعداد بازی‌ها
        $homeStanding->played++;
        $awayStanding->played++;

        // گل زده و خورده
        $homeGoals = $fixture->home_score;
        $awayGoals = $fixture->away_score;

        $homeStanding->goals_for += $homeGoals;
        $homeStanding->goals_against += $awayGoals;

        $awayStanding->goals_for += $awayGoals;
        $awayStanding->goals_against += $homeGoals;

        // محاسبه تفاضل گل جدید
        $homeStanding->goal_difference = $homeStanding->goals_for - $homeStanding->goals_against;
        $awayStanding->goal_difference = $awayStanding->goals_for - $awayStanding->goals_against;

        // نتیجه بازی
        if ($homeGoals > $awayGoals) {
            $homeStanding->wins++;
            $awayStanding->losses++;
            $homeStanding->points += 3;
        } elseif ($homeGoals < $awayGoals) {
            $awayStanding->wins++;
            $homeStanding->losses++;
            $awayStanding->points += 3;
        } else {
            $homeStanding->draws++;
            $awayStanding->draws++;
            $homeStanding->points += 1;
            $awayStanding->points += 1;
        }

        $homeStanding->save();
        $awayStanding->save();

        // می‌تونی بعداً این قسمت رو برای ریل‌تایم فعال کنی
        // dispatch(new BroadcastStandingsUpdated($fixture->league_id));
    }
}
