<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Payment;
use App\Models\Powerbank;
use App\Models\Rental;
use App\Models\Station;
use App\Models\Tariff;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'users' => User::orderBy('name')->get(),
            'stations' => Station::withCount('powerbanks')->latest()->get(),
            'powerbanks' => Powerbank::with('station')->latest()->get(),
            'tariffs' => Tariff::latest()->get(),
            'rentals' => Rental::with(['user', 'powerbank.station', 'tariff', 'payment'])->latest()->get(),
            'payments' => Payment::with('rental.user')->latest()->get(),
            'errorLogs' => ErrorLog::latest()->get(),
            'activeRentals' => Rental::with(['user', 'powerbank'])->where('status', 'active')->latest()->get(),
            'unpaidRentals' => Rental::with(['user', 'powerbank', 'payment'])->whereDoesntHave('payment')->latest()->get(),
            'activeRentalsCount' => Rental::where('status', 'active')->count(),
            'availablePowerbanksCount' => Powerbank::where('status', 'available')->count(),
        ]);
    }
}
