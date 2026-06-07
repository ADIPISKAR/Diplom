<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequestRequest;
use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentRequest;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentRequestController extends Controller
{
    public function index(Request $request): View
    {
        return view('requests.index', [
            'requests' => $request->user()
                ->equipmentRequests()
                ->with(['category', 'equipment', 'storageLocation', 'issueRecord.employee', 'returnRecord.employee'])
                ->latest('requested_at')
                ->paginate(15),
        ]);
    }

    public function create(Request $request): View
    {
        $equipment = $request->filled('equipment_id')
            ? Equipment::with(['category', 'storageLocation'])->findOrFail($request->integer('equipment_id'))
            : null;

        return view('requests.create', [
            'equipment' => $equipment,
            'categories' => EquipmentCategory::where('is_active', true)->orderBy('name')->get(),
            'locations' => StorageLocation::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreEquipmentRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['equipment_id'])) {
            $equipment = Equipment::with(['category', 'storageLocation'])->findOrFail($data['equipment_id']);

            if (! $equipment->isAvailable()) {
                return back()->withInput()->with('error', 'Выбранное оборудование сейчас недоступно.');
            }

            $data['category_id'] = $equipment->category_id;
            $data['storage_location_id'] = $equipment->storage_location_id;
        }

        $equipmentRequest = $request->user()->equipmentRequests()->create($data + [
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        ActivityLog::record($request->user()->id, 'equipment_request_created', 'Создана заявка на выдачу оборудования', $equipmentRequest);

        return redirect()->route('requests.index')->with('success', 'Заявка отправлена сотруднику выдачи.');
    }

    public function requestReturn(Request $request, EquipmentRequest $equipmentRequest): RedirectResponse
    {
        abort_unless($equipmentRequest->user_id === $request->user()->id && $equipmentRequest->status === 'issued', 403);

        $equipmentRequest->update(['status' => 'return_requested']);
        ActivityLog::record($request->user()->id, 'return_requested', "Пользователь запросил возврат по заявке #{$equipmentRequest->id}", $equipmentRequest);

        return back()->with('success', 'Запрос на возврат отправлен сотруднику выдачи.');
    }
}
