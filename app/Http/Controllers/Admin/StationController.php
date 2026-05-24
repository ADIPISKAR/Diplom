<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStationRequest;
use App\Models\ActivityLog;
use App\Models\Station;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StationController extends Controller
{
    public function index(): View
    {
        return view('admin.stations.index', [
            'stations' => Station::withCount(['slots', 'powerbanks', 'availablePowerbanks'])->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.stations.create');
    }

    public function store(StoreStationRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $station = Station::create($request->validated());

            for ($slotNumber = 1; $slotNumber <= $station->total_slots; $slotNumber++) {
                $station->slots()->create([
                    'slot_number' => $slotNumber,
                    'status' => 'empty',
                ]);
            }

            ActivityLog::record($request->user()->id, 'admin_station_created', "Создана станция {$station->name}");
        });

        return redirect()->route('admin.stations.index')->with('success', 'Станция создана.');
    }

    public function edit(Station $station): View
    {
        return view('admin.stations.edit', ['station' => $station]);
    }

    public function update(StoreStationRequest $request, Station $station): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $station): void {
                $oldSlots = $station->total_slots;
                $station->update($request->validated());

                if ($station->total_slots > $oldSlots) {
                    for ($slotNumber = $oldSlots + 1; $slotNumber <= $station->total_slots; $slotNumber++) {
                        $station->slots()->create(['slot_number' => $slotNumber, 'status' => 'empty']);
                    }
                }

                if ($station->total_slots < $oldSlots) {
                    $blocked = $station->slots()
                        ->where('slot_number', '>', $station->total_slots)
                        ->where('status', '!=', 'empty')
                        ->exists();

                    if ($blocked) {
                        throw new \RuntimeException('Нельзя уменьшить количество слотов: среди удаляемых есть занятые.');
                    }

                    $station->slots()->where('slot_number', '>', $station->total_slots)->delete();
                }

                ActivityLog::record($request->user()->id, 'admin_station_updated', "Обновлена станция {$station->name}");
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.stations.index')->with('success', 'Станция обновлена.');
    }

    public function destroy(Station $station): RedirectResponse
    {
        $name = $station->name;
        $station->delete();
        ActivityLog::record(auth()->id(), 'admin_station_deleted', "Удалена станция {$name}");

        return back()->with('success', 'Станция удалена.');
    }
}
