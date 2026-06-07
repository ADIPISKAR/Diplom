<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'storage_location_id' => ['nullable', 'exists:storage_locations,id'],
            'equipment_id' => ['nullable', 'exists:equipment,id'],
            'user_comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
