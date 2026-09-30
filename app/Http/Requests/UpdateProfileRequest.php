<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:120'],
            'role_title' => ['sometimes', 'required', 'string', 'max:160'],
            'hero_title' => ['sometimes', 'required', 'string', 'max:255'],
            'hero_highlight' => ['nullable', 'string', 'max:60'],
            'hero_description' => ['sometimes', 'required', 'string'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'photo_caption' => ['nullable', 'string', 'max:120'],
            'quote' => ['nullable', 'string'],
            'quote_author' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'location' => ['nullable', 'string', 'max:120'],
            'contact_intro' => ['nullable', 'string'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:8192'],
            'footer_text' => ['nullable', 'string', 'max:160'],
        ];
    }
}
