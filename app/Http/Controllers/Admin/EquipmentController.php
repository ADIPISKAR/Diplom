<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEquipmentRequest;
use App\Models\ActivityLog;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\StorageLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(): View
    {
        return view('admin.equipment.index', [
            'equipment' => Equipment::with(['category', 'storageLocation', 'specification'])->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.equipment.create', $this->formData());
    }

    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $equipment = Equipment::create($this->equipmentData($data));
        $this->syncSpecification($equipment, $data);
        $this->syncSoftware($equipment, $data);
        ActivityLog::record($request->user()->id, 'equipment_created', "Добавлено оборудование {$equipment->inventory_number}", $equipment);

        return redirect()->route('admin.equipment.index')->with('success', 'Оборудование добавлено.');
    }

    public function edit(Equipment $equipment): View
    {
        return view('admin.equipment.edit', $this->formData() + [
            'equipment' => $equipment->load(['specification', 'software']),
        ]);
    }

    public function update(StoreEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        $data = $request->validated();
        $equipment->update($this->equipmentData($data));
        $this->syncSpecification($equipment, $data);
        $this->syncSoftware($equipment, $data);
        ActivityLog::record($request->user()->id, 'equipment_updated', "Обновлено оборудование {$equipment->inventory_number}", $equipment);

        return redirect()->route('admin.equipment.index')->with('success', 'Оборудование обновлено.');
    }

    public function destroy(Equipment $equipment): RedirectResponse
    {
        $number = $equipment->inventory_number;
        $equipment->delete();
        ActivityLog::record(auth()->id(), 'equipment_deleted', "Удалено оборудование {$number}");

        return back()->with('success', 'Оборудование удалено.');
    }

    private function formData(): array
    {
        return [
            'categories' => EquipmentCategory::where('is_active', true)->orderBy('name')->get(),
            'locations' => StorageLocation::where('is_active', true)->orderBy('name')->get(),
        ];
    }

    private function equipmentData(array $data): array
    {
        return collect($data)->only([
            'name',
            'inventory_number',
            'category_id',
            'storage_location_id',
            'technical_condition',
            'status',
            'description',
        ])->all();
    }

    private function syncSpecification(Equipment $equipment, array $data): void
    {
        $specification = collect($data)->only([
            'processor',
            'ram',
            'storage',
            'screen_size',
            'operating_system',
            'battery_condition',
            'additional_info',
        ])->all();

        if (collect($specification)->filter(fn ($value) => filled($value))->isEmpty()) {
            $equipment->specification()?->delete();
            return;
        }

        $equipment->specification()->updateOrCreate([], $specification);
    }

    private function syncSoftware(Equipment $equipment, array $data): void
    {
        $equipment->software()->delete();

        foreach (($data['software_name'] ?? []) as $index => $name) {
            if (! filled($name)) {
                continue;
            }

            $equipment->software()->create([
                'name' => $name,
                'version' => $data['software_version'][$index] ?? null,
                'license_type' => $data['software_license_type'][$index] ?? null,
                'description' => $data['software_description'][$index] ?? null,
            ]);
        }
    }
}
