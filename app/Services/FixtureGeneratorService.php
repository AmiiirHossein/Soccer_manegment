<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FixtureGeneratorService
{
    public function generate(League $league): void
    {
        $teams = $league->teams;

        if ($teams->count() < 2) {
            throw new \Exception("At least 2 teams are required to generate fixtures.");
        }

        $teamIds = $teams->pluck('id')->toArray();
        $startDate = Carbon::parse($league->start_date)->copy();
        $matchIntervalDays = 3;
        $fixtures = [];

        // Generate round-robin matches (single leg)
        $rounds = $this->generateRoundRobinMatches($teamIds);

        // Generate first half (رفت)
        $currentDate = $startDate->copy();
        foreach ($rounds as $round) {
            foreach ($round as $match) {
                $fixtures[] = [
                    'league_id' => $league->id,
                    'home_team_id' => $match[0],
                    'away_team_id' => $match[1],
                    'match_date' => $currentDate->toDateString(),
                    'status' => 'scheduled',
                    'location' => 'TBD',
                    'home_score' => 0,
                    'away_score' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $currentDate->addDays($matchIntervalDays);
        }

        // Generate second half (برگشت)
        foreach ($rounds as $round) {
            foreach ($round as $match) {
                $fixtures[] = [
                    'league_id' => $league->id,
                    'home_team_id' => $match[1],
                    'away_team_id' => $match[0],
                    'match_date' => $currentDate->toDateString(),
                    'status' => 'scheduled',
                    'location' => 'TBD',
                    'home_score' => 0,
                    'away_score' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $currentDate->addDays($matchIntervalDays);
        }

        Fixture::insert($fixtures);
    }

    private function generateRoundRobinMatches(array $teamIds): array
    {
        $count = count($teamIds);

        if ($count % 2 !== 0) {
            $teamIds[] = null; // Add a dummy team for bye
            $count++;
        }

        $rounds = [];
        $half = $count / 2;
        $teams = $teamIds;

        for ($i = 0; $i < $count - 1; $i++) {
            $round = [];
            for ($j = 0; $j < $half; $j++) {
                $teamA = $teams[$j];
                $teamB = $teams[$count - 1 - $j];
                if ($teamA !== null && $teamB !== null) {
                    $round[] = [$teamA, $teamB];
                }
            }
            $rounds[] = $round;

            // Rotate teams except the first one
            $fixed = array_shift($teams);
            $last = array_pop($teams);
            array_unshift($teams, $last);
            array_unshift($teams, $fixed);
        }

        return $rounds;
    }
}
