<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePowerbankRequest;
use App\Models\ActivityLog;
use App\Models\Powerbank;
use App\Models\Station;
use App\Models\StationSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PowerbankController extends Controller
{
    public function index(): View
    {
        return view('admin.powerbanks.index', [
            'powerbanks' => Powerbank::with(['station', 'slot'])->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.powerbanks.create', $this->formData());
    }

    public function store(StorePowerbankRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request): void {
                $data = $this->normalizedData($request->validated());
                $powerbank = Powerbank::create($data);
                $this->syncSlotStatuses(null, $powerbank);
                ActivityLog::record($request->user()->id, 'admin_powerbank_created', "Добавлен повербанк {$powerbank->serial_number}");
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.powerbanks.index')->with('success', 'Повербанк создан.');
    }

    public function edit(Powerbank $powerbank): View
    {
        return view('admin.powerbanks.edit', $this->formData() + ['powerbank' => $powerbank]);
    }

    public function update(StorePowerbankRequest $request, Powerbank $powerbank): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $powerbank): void {
                $oldSlotId = $powerbank->slot_id;
                $powerbank->update($this->normalizedData($request->validated()));
                $this->syncSlotStatuses($oldSlotId, $powerbank);
                ActivityLog::record($request->user()->id, 'admin_powerbank_updated', "Обновлён повербанк {$powerbank->serial_number}");
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.powerbanks.index')->with('success', 'Повербанк обновлён.');
    }

    public function destroy(Powerbank $powerbank): RedirectResponse
    {
        $serial = $powerbank->serial_number;
        $oldSlotId = $powerbank->slot_id;
        $powerbank->delete();

        if ($oldSlotId) {
            StationSlot::whereKey($oldSlotId)->update(['status' => 'empty']);
        }

        ActivityLog::record(auth()->id(), 'admin_powerbank_deleted', "Удалён повербанк {$serial}");

        return back()->with('success', 'Повербанк удалён.');
    }

    private function formData(): array
    {
        return [
            'stations' => Station::with('slots')->orderBy('name')->get(),
            'slots' => StationSlot::with('station')->orderBy('station_id')->orderBy('slot_number')->get(),
        ];
    }

    private function normalizedData(array $data): array
    {
        $data['station_id'] = $data['station_id'] ?: null;
        $data['slot_id'] = $data['slot_id'] ?: null;

        if ($data['slot_id']) {
            $slot = StationSlot::findOrFail($data['slot_id']);

            if ((int) $slot->station_id !== (int) $data['station_id']) {
                throw new \RuntimeException('Выбранный слот не принадлежит выбранной станции.');
            }
        }

        if ($data['status'] === 'rented') {
            $data['slot_id'] = null;
        }

        return $data;
    }

    private function syncSlotStatuses(?int $oldSlotId, Powerbank $powerbank): void
    {
        if ($oldSlotId && $oldSlotId !== $powerbank->slot_id) {
            StationSlot::whereKey($oldSlotId)->update(['status' => 'empty']);
        }

        if ($powerbank->slot_id) {
            StationSlot::whereKey($powerbank->slot_id)->update(['status' => 'occupied']);
        }
    }
}
