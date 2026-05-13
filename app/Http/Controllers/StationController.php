<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function store(Request $request)
    {
        Station::create($request->validate([
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,maintenance,inactive'],
        ]));

        return redirect()->route('dashboard')->with('success', 'Станция добавлена.');
    }

    public function update(Request $request, Station $station)
    {
        $station->update($request->validate([
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,maintenance,inactive'],
        ]));

        return redirect()->route('dashboard')->with('success', 'Станция обновлена.');
    }

    public function destroy(Station $station)
    {
        $station->delete();

        return redirect()->route('dashboard')->with('success', 'Станция удалена.');
    }
}
