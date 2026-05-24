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
            'rental_id' => ['nullable', 'exists:rentals,id'],
            'station_id' => ['nullable', 'exists:stations,id'],
            'powerbank_id' => ['nullable', 'exists:powerbanks,id'],
            'issue_type' => ['required', Rule::in(['station_error', 'powerbank_not_returned', 'payment_error', 'broken_powerbank', 'slot_error', 'other'])],
            'description' => ['required', 'string', 'max:5000'],
        ];
    }
}
