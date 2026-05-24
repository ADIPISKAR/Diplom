<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Rental;
use App\Models\Station;
use App\Models\Tariff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function create(Request $request, Station $station): RedirectResponse|View
    {
        if ($request->user()->activeRental()) {
            return redirect()->route('rentals.current')->with('error', 'У вас уже есть активная аренда.');
        }

        return view('stations.rent', [
            'station' => $station->loadCount('availablePowerbanks'),
            'tariff' => Tariff::where('is_active', true)->first(),
        ]);
    }

    public function store(Request $request, Station $station): RedirectResponse
    {
        $user = $request->user();

        try {
            DB::transaction(function () use ($station, $user): void {
                $hasActiveRental = Rental::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->lockForUpdate()
                    ->exists();

                if ($hasActiveRental) {
                    throw new \RuntimeException('У вас уже есть активная аренда.');
                }

                $powerbank = $station->powerbanks()
                    ->where('status', 'available')
                    ->where('condition', 'good')
                    ->lockForUpdate()
                    ->first();

                if (! $powerbank) {
                    throw new \RuntimeException('На выбранной станции нет доступных повербанков.');
                }

                $tariff = Tariff::where('is_active', true)->first();

                if (! $tariff) {
                    throw new \RuntimeException('Нет активного тарифа для оформления аренды.');
                }

                $slot = $powerbank->slot()->lockForUpdate()->first();

                Rental::create([
                    'user_id' => $user->id,
                    'powerbank_id' => $powerbank->id,
                    'start_station_id' => $station->id,
                    'tariff_id' => $tariff->id,
                    'started_at' => now(),
                    'status' => 'active',
                    'total_price' => 0,
                ]);

                $powerbank->update([
                    'status' => 'rented',
                    'slot_id' => null,
                ]);

                $slot?->update(['status' => 'empty']);

                ActivityLog::record(
                    $user->id,
                    'rental_created',
                    "Создана аренда повербанка {$powerbank->serial_number} на станции {$station->name}"
                );
            });
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('rentals.current')->with('success', 'Аренда оформлена.');
    }

    public function current(Request $request): View
    {
        $rental = $request->user()
            ->rentals()
            ->where('status', 'active')
            ->with(['powerbank', 'startStation', 'tariff'])
            ->latest('started_at')
            ->first();

        return view('rentals.current', [
            'rental' => $rental,
            'currentPrice' => $rental?->calculatePrice(),
        ]);
    }

    public function history(Request $request): View
    {
        return view('rentals.history', [
            'rentals' => $request->user()
                ->rentals()
                ->with(['powerbank', 'startStation', 'returnStation', 'tariff', 'payments'])
                ->latest('started_at')
                ->paginate(15),
        ]);
    }
}
