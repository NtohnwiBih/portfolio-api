<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAchievementRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:180'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:60'],
            'metric_label' => ['required', 'string', 'max:80'],
            'order' => ['nullable', 'integer', 'min:0'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:40'],
        ];
    }
}
