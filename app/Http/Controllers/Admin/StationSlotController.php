<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Station;
use App\Models\StationSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class StationSlotController extends Controller
{
    public function index(Station $station): View
    {
        return view('admin.stations.slots', [
            'station' => $station->load(['slots.powerbank']),
        ]);
    }

    public function update(Request $request, Station $station, StationSlot $slot): RedirectResponse
    {
        abort_unless($slot->station_id === $station->id, 404);

        $data = $request->validate([
            'status' => ['required', Rule::in(['empty', 'occupied', 'blocked', 'maintenance'])],
        ]);

        $slot->update($data);
        ActivityLog::record($request->user()->id, 'admin_slot_updated', "Изменён слот #{$slot->slot_number} станции {$station->name}");

        return back()->with('success', 'Статус слота обновлён.');
    }
}
