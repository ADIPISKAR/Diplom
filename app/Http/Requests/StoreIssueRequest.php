<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipment_request_id' => ['nullable', 'exists:equipment_requests,id'],
            'equipment_id' => ['nullable', 'exists:equipment,id'],
            'issue_type' => ['required', Rule::in(['broken_equipment', 'late_return', 'wrong_status', 'lost_equipment', 'other'])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
        ];
    }
}
