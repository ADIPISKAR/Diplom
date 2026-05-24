<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Station;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'activeRental' => $user->activeRental()?->load(['powerbank', 'startStation', 'tariff']),
            'rentalsCount' => Rental::where('user_id', $user->id)->count(),
            'stationsCount' => Station::where('status', 'active')->count(),
            'issuesCount' => $user->issues()->count(),
            'notifications' => $user->notifications()->latest('created_at')->limit(5)->get(),
            'recentLogs' => ActivityLog::where('user_id', $user->id)->latest('created_at')->limit(6)->get(),
            'stations' => Station::withCount('availablePowerbanks')->where('status', 'active')->limit(3)->get(),
        ]);
    }
}
