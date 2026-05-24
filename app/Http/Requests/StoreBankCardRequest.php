<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'card_number' => ['required', 'digits_between:12,19'],
            'is_default' => ['nullable', 'boolean'],
        ];
    }
}
