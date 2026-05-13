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
        $powerbankStatusCounts = Powerbank::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $rentalStatusCounts = Rental::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stations = Station::withCount('powerbanks')->latest()->get();
        $stationLoad = $stations->map(fn (Station $station) => [
            'label' => $station->location,
            'value' => $station->powerbanks_count,
        ]);

        $maxStationLoad = max(1, $stationLoad->max('value') ?? 1);
        $paidRevenue = Payment::where('status', 'paid')->sum('amount');
        $powerbanksTotal = max(1, Powerbank::count());
        $availablePowerbanksCount = (int) ($powerbankStatusCounts['available'] ?? 0);

        return view('dashboard', [
            'users' => User::orderBy('name')->get(),
            'stations' => $stations,
            'powerbanks' => Powerbank::with('station')->latest()->get(),
            'tariffs' => Tariff::latest()->get(),
            'rentals' => Rental::with(['user', 'powerbank.station', 'tariff', 'payment'])->latest()->get(),
            'payments' => Payment::with('rental.user')->latest()->get(),
            'errorLogs' => ErrorLog::latest()->get(),
            'activeRentals' => Rental::with(['user', 'powerbank'])->where('status', 'active')->latest()->get(),
            'unpaidRentals' => Rental::with(['user', 'powerbank', 'payment'])->whereDoesntHave('payment')->latest()->get(),
            'activeRentalsCount' => Rental::where('status', 'active')->count(),
            'availablePowerbanksCount' => $availablePowerbanksCount,
            'paidRevenue' => $paidRevenue,
            'powerbankAvailabilityPercent' => round($availablePowerbanksCount / $powerbanksTotal * 100),
            'powerbankStatusChart' => [
                ['label' => 'Доступны', 'value' => (int) ($powerbankStatusCounts['available'] ?? 0), 'color' => '#2563eb'],
                ['label' => 'В аренде', 'value' => (int) ($powerbankStatusCounts['rented'] ?? 0), 'color' => '#14b8a6'],
                ['label' => 'Обслуживание', 'value' => (int) ($powerbankStatusCounts['maintenance'] ?? 0), 'color' => '#f59e0b'],
                ['label' => 'Потеряны', 'value' => (int) ($powerbankStatusCounts['lost'] ?? 0), 'color' => '#ef4444'],
            ],
            'rentalStatusChart' => [
                ['label' => 'Активные', 'value' => (int) ($rentalStatusCounts['active'] ?? 0), 'color' => '#2563eb'],
                ['label' => 'Завершены', 'value' => (int) ($rentalStatusCounts['completed'] ?? 0), 'color' => '#14b8a6'],
                ['label' => 'Просрочены', 'value' => (int) ($rentalStatusCounts['overdue'] ?? 0), 'color' => '#f59e0b'],
                ['label' => 'Отменены', 'value' => (int) ($rentalStatusCounts['cancelled'] ?? 0), 'color' => '#64748b'],
            ],
            'stationLoadChart' => $stationLoad,
            'maxStationLoad' => $maxStationLoad,
        ]);
    }
}
