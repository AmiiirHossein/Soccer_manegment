<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\League;
use App\Repositories\FixtureRepo;
use App\Services\FixtureGeneratorService;
use App\Services\MatchResultService;
use Illuminate\Support\Collection;
use Exception;

class FixtureService
{
    protected FixtureRepo $fixtureRepository;
    protected FixtureGeneratorService $fixtureGenerator;
    protected MatchResultService $matchResultService;

    public function __construct(
        FixtureRepo $fixtureRepository,
        FixtureGeneratorService $fixtureGenerator,
        MatchResultService $matchResultService
    ) {
        $this->fixtureRepository = $fixtureRepository;
        $this->fixtureGenerator = $fixtureGenerator;
        $this->matchResultService = $matchResultService;
    }

    public function generateFixtures(League $league): void
    {
        $this->fixtureGenerator->generate($league);
    }

    public function getFixturesForLeague(League $league): Collection
    {
        return $this->fixtureRepository->getFixturesByLeague($league)
            ->map(function ($fixture) {
                return [
                    'match_date' => $fixture->match_date,
                    'home_team' => $fixture->homeTeam->name,
                    'away_team' => $fixture->awayTeam->name,
                    'home_score' => $fixture->home_score,
                    'away_score' => $fixture->away_score,
                    'location' => $fixture->location,
                    'status' => $fixture->status,
                ];
            });
    }

    public function submitResult(Fixture $fixture, int $homeScore, int $awayScore): Fixture
    {
        if ($fixture->status !== 'scheduled') {
            throw new Exception('This match is already processed.');
        }

        $fixture->home_score = $homeScore;
        $fixture->away_score = $awayScore;
        $fixture->status = 'finished';

        $this->fixtureRepository->save($fixture);
        $this->matchResultService->processMatch($fixture);

        return $fixture->fresh();
    }
}
