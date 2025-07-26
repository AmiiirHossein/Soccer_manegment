<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Services\StandingService;
use Illuminate\Http\Request;
use App\Models\Fixture;

class StandingController extends Controller
{

    protected StandingService $service;

    public function __construct(StandingService $service)
    {
        $this->service = $service;
    }
    public function index(League $league)
    {
        $standings = $this->service->getLeagueStandings($league);
        return response()->json($standings);
    }

    }
