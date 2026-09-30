<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gated by auth:sanctum middleware on the route
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180', 'unique:projects,slug'],
            'type' => ['required', Rule::in(['frontend', 'backend', 'fullstack'])],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['string', 'max:60'],
            'is_featured' => ['boolean'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],

            // Frontend/UI projects: multiple screenshots
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'image_captions' => ['nullable', 'array'],
            'image_captions.*' => ['nullable', 'string', 'max:180'],

            // Any project: flexible link list (live site, repo, docs, demo video...)
            'links' => ['nullable', 'array'],
            'links.*.label' => ['required_with:links', 'string', 'max:80'],
            'links.*.type' => ['required_with:links', Rule::in(['live', 'repo', 'docs', 'case_study', 'video', 'other'])],
            'links.*.url' => ['required_with:links', 'url', 'max:255'],
        ];
    }
}
