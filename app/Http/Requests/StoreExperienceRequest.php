<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'role_title' => ['required', 'string', 'max:160'],
            'company' => ['required', 'string', 'max:160'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['string', 'max:255'],
        ];
    }
}
