<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialLinkRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'platform' => ['required', 'string', 'max:60'],
            'icon' => ['nullable', 'string', 'max:60'],
            'url' => ['required', 'url', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
