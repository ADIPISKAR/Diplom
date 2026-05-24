<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePowerbankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $powerbankId = $this->route('powerbank')?->id;

        return [
            'serial_number' => ['required', 'string', 'max:255', Rule::unique('powerbanks', 'serial_number')->ignore($powerbankId)],
            'station_id' => ['nullable', 'exists:stations,id'],
            'slot_id' => ['nullable', 'exists:station_slots,id', Rule::unique('powerbanks', 'slot_id')->ignore($powerbankId)],
            'charge_level' => ['required', 'integer', 'min:0', 'max:100'],
            'status' => ['required', Rule::in(['available', 'rented', 'maintenance', 'broken', 'lost'])],
            'condition' => ['required', Rule::in(['good', 'needs_service', 'damaged'])],
        ];
    }
}
