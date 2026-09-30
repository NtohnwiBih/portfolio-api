<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'title' => ['sometimes', 'required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180', Rule::unique('projects', 'slug')->ignore($projectId)],
            'type' => ['sometimes', 'required', Rule::in(['frontend', 'backend', 'fullstack'])],
            'short_description' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['string', 'max:60'],
            'is_featured' => ['boolean'],
            'status' => ['sometimes', 'required', Rule::in(['draft', 'published'])],
            'order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'image_captions' => ['nullable', 'array'],
            'image_captions.*' => ['nullable', 'string', 'max:180'],
            'links' => ['nullable', 'array'],
            'links.*.label' => ['required_with:links', 'string', 'max:80'],
            'links.*.type' => ['required_with:links', Rule::in(['live', 'repo', 'docs', 'case_study', 'video', 'other'])],
            'links.*.url' => ['required_with:links', 'url', 'max:255'],
        ];
    }
}
