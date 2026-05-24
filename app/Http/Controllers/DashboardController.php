<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Station;
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
            'notifications' => $user->notifications()->latest('created_at')->limit(5)->get(),
        ]);
    }
}
