<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $stationId = $this->route('station')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'building' => ['required', 'string', 'max:255'],
            'floor' => ['required', 'string', 'max:50'],
            'location_description' => ['nullable', 'string', 'max:2000'],
            'qr_code' => ['required', 'string', 'max:255', Rule::unique('stations', 'qr_code')->ignore($stationId)],
            'total_slots' => ['required', 'integer', 'min:1', 'max:100'],
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
        ];
    }
}
