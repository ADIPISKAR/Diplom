<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentIssue;
use App\Models\EquipmentRequest;
use App\Models\EquipmentReturn;
use App\Models\Notification;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EquipmentRequestController extends Controller
{
    public function index(): View
    {
        return view('employee.requests.index', [
            'requests' => EquipmentRequest::with(['user', 'category', 'equipment', 'storageLocation'])
                ->latest('requested_at')
                ->paginate(25),
        ]);
    }

    public function edit(EquipmentRequest $equipmentRequest): View
    {
        return view('employee.requests.edit', [
            'requestModel' => $equipmentRequest->load(['user', 'category', 'equipment', 'storageLocation']),
            'equipment' => Equipment::with(['category', 'storageLocation'])
                ->where('category_id', $equipmentRequest->category_id)
                ->orderBy('name')
                ->get(),
            'locations' => StorageLocation::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function approve(Request $request, EquipmentRequest $equipmentRequest): RedirectResponse
    {
        $data = $request->validate([
            'equipment_id' => ['required', 'exists:equipment,id'],
            'employee_comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $equipment = Equipment::whereKey($data['equipment_id'])
            ->where('category_id', $equipmentRequest->category_id)
            ->firstOrFail();

        if (! $equipment->isAvailable()) {
            return back()->withInput()->with('error', 'Выбранное оборудование недоступно для выдачи.');
        }

        $equipmentRequest->update([
            'equipment_id' => $equipment->id,
            'storage_location_id' => $equipment->storage_location_id,
            'status' => 'approved',
            'employee_comment' => $data['employee_comment'] ?? null,
            'approved_at' => now(),
        ]);

        Notification::create([
            'user_id' => $equipmentRequest->user_id,
            'title' => 'Заявка подтверждена',
            'message' => "К выдаче подготовлено оборудование: {$equipment->name}.",
        ]);

        ActivityLog::record($request->user()->id, 'request_approved', "Подтверждена заявка #{$equipmentRequest->id}", $equipmentRequest);

        return back()->with('success', 'Заявка подтверждена.');
    }

    public function issue(Request $request, EquipmentRequest $equipmentRequest): RedirectResponse
    {
        if (! in_array($equipmentRequest->status, ['approved', 'pending'], true)) {
            return back()->with('error', 'Эту заявку нельзя выдать в текущем статусе.');
        }

        try {
            DB::transaction(function () use ($request, $equipmentRequest): void {
                $equipmentRequest = EquipmentRequest::whereKey($equipmentRequest->id)->lockForUpdate()->firstOrFail();
                $equipment = Equipment::whereKey($equipmentRequest->equipment_id)->lockForUpdate()->firstOrFail();

                if (! $equipment->isAvailable()) {
                    throw new \RuntimeException('Оборудование уже недоступно.');
                }

                EquipmentIssue::create([
                    'request_id' => $equipmentRequest->id,
                    'user_id' => $equipmentRequest->user_id,
                    'employee_id' => $request->user()->id,
                    'equipment_id' => $equipment->id,
                    'storage_location_id' => $equipment->storage_location_id,
                    'issued_at' => now(),
                    'comment' => $equipmentRequest->employee_comment,
                ]);

                $equipment->update(['status' => 'issued']);
                $equipmentRequest->update(['status' => 'issued']);

                Notification::create([
                    'user_id' => $equipmentRequest->user_id,
                    'title' => 'Оборудование выдано',
                    'message' => "Вы получили оборудование: {$equipment->name}.",
                ]);

                ActivityLog::record($request->user()->id, 'equipment_issued', "Выдано оборудование {$equipment->inventory_number}", $equipmentRequest);
            });
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Выдача оборудования зафиксирована.');
    }

    public function completeReturn(Request $request, EquipmentRequest $equipmentRequest): RedirectResponse
    {
        $data = $request->validate([
            'storage_location_id' => ['required', 'exists:storage_locations,id'],
            'condition_after_return' => ['required', Rule::in(['good', 'needs_check', 'broken'])],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        abort_unless(in_array($equipmentRequest->status, ['issued', 'return_requested'], true), 403);

        DB::transaction(function () use ($data, $request, $equipmentRequest): void {
            $equipmentRequest = EquipmentRequest::whereKey($equipmentRequest->id)
                ->with('equipment')
                ->lockForUpdate()
                ->firstOrFail();

            EquipmentReturn::create([
                'request_id' => $equipmentRequest->id,
                'equipment_id' => $equipmentRequest->equipment_id,
                'user_id' => $equipmentRequest->user_id,
                'employee_id' => $request->user()->id,
                'storage_location_id' => $data['storage_location_id'],
                'returned_at' => now(),
                'condition_after_return' => $data['condition_after_return'],
                'comment' => $data['comment'] ?? null,
            ]);

            $equipmentRequest->equipment->update([
                'storage_location_id' => $data['storage_location_id'],
                'technical_condition' => $data['condition_after_return'],
                'status' => $data['condition_after_return'] === 'good' ? 'available' : 'checking',
            ]);

            $equipmentRequest->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            Notification::create([
                'user_id' => $equipmentRequest->user_id,
                'title' => 'Возврат оборудования завершён',
                'message' => 'Сотрудник выдачи зафиксировал возврат оборудования.',
            ]);

            ActivityLog::record($request->user()->id, 'equipment_returned', "Возврат по заявке #{$equipmentRequest->id}", $equipmentRequest);
        });

        return redirect()->route('employee.requests.index')->with('success', 'Возврат оборудования зафиксирован.');
    }

    public function reject(Request $request, EquipmentRequest $equipmentRequest): RedirectResponse
    {
        $data = $request->validate([
            'employee_comment' => ['required', 'string', 'max:1000'],
        ]);

        abort_unless($equipmentRequest->status === 'pending', 403);

        $equipmentRequest->update([
            'status' => 'rejected',
            'employee_comment' => $data['employee_comment'],
            'completed_at' => now(),
        ]);

        Notification::create([
            'user_id' => $equipmentRequest->user_id,
            'title' => 'Заявка отклонена',
            'message' => $data['employee_comment'],
        ]);

        ActivityLog::record($request->user()->id, 'request_rejected', "Отклонена заявка #{$equipmentRequest->id}", $equipmentRequest);

        return redirect()->route('employee.requests.index')->with('success', 'Заявка отклонена.');
    }
}
