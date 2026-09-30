<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'short_description' => $this->short_description,
            'description' => $this->when($request->routeIs('*.show'), $this->description),
            'tech_stack' => $this->tech_stack ?? [],
            'cover_image_url' => $this->cover_image_url,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($img) => [
                'id' => $img->id,
                'url' => $img->image_url,
                'caption' => $img->caption,
            ])),
            'links' => $this->whenLoaded('links', fn () => $this->links->map(fn ($l) => [
                'id' => $l->id,
                'label' => $l->label,
                'type' => $l->type,
                'url' => $l->url,
            ])),
        ];
    }
}
