<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\View\View;

class StationController extends Controller
{
    public function index(): View
    {
        return view('stations.index', [
            'stations' => Station::withCount(['slots', 'availablePowerbanks'])
                ->orderBy('building')
                ->orderBy('floor')
                ->get(),
        ]);
    }

    public function show(Station $station): View
    {
        return view('stations.show', [
            'station' => $station->load(['slots.powerbank', 'availablePowerbanks']),
        ]);
    }
}
