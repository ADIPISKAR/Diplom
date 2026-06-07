<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $equipmentId = $this->route('equipment')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'inventory_number' => ['required', 'string', 'max:255', Rule::unique('equipment', 'inventory_number')->ignore($equipmentId)],
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'storage_location_id' => ['required', 'exists:storage_locations,id'],
            'technical_condition' => ['required', Rule::in(['good', 'needs_check', 'broken'])],
            'status' => ['required', Rule::in(['available', 'issued', 'returned', 'checking', 'broken', 'lost'])],
            'description' => ['nullable', 'string', 'max:3000'],
            'processor' => ['nullable', 'string', 'max:255'],
            'ram' => ['nullable', 'string', 'max:255'],
            'storage' => ['nullable', 'string', 'max:255'],
            'screen_size' => ['nullable', 'string', 'max:255'],
            'operating_system' => ['nullable', 'string', 'max:255'],
            'battery_condition' => ['nullable', 'string', 'max:255'],
            'additional_info' => ['nullable', 'string', 'max:3000'],
            'software_name' => ['nullable', 'array'],
            'software_name.*' => ['nullable', 'string', 'max:255'],
            'software_version' => ['nullable', 'array'],
            'software_version.*' => ['nullable', 'string', 'max:255'],
            'software_license_type' => ['nullable', 'array'],
            'software_license_type.*' => ['nullable', 'string', 'max:255'],
            'software_description' => ['nullable', 'array'],
            'software_description.*' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
