<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\FixtureService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\League;
use App\Models\Fixture;

class FixtureController extends Controller
{
    protected FixtureService $fixtureService;

    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }

    public function generate(League $league): JsonResponse
    {
        try {
            $this->fixtureService->generateFixtures($league);

            return response()->json([
                'message' => 'Fixtures generated successfully.',
                'league_id' => $league->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to generate fixtures.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function index(League $league): JsonResponse
    {
        $fixtures = $this->fixtureService->getFixturesForLeague($league);
        return response()->json($fixtures);
    }

    public function submitResult(Request $request, Fixture $fixture): JsonResponse
    {
        try {
            $updatedFixture = $this->fixtureService->submitResult(
                $fixture,
                $request->home_score,
                $request->away_score
            );

            return response()->json([
                'message' => 'Result submitted successfully.',
                'fixture' => $updatedFixture
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
