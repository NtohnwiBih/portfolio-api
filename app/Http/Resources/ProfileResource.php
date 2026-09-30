<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'role_title' => $this->role_title,
            'hero_title' => $this->hero_title,
            'hero_highlight' => $this->hero_highlight,
            'hero_description' => $this->hero_description,
            'photo_url' => $this->photo_url,
            'photo_caption' => $this->photo_caption,
            'quote' => $this->quote,
            'quote_author' => $this->quote_author,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'contact_intro' => $this->contact_intro,
            'resume_url' => $this->resume_url,
            'footer_text' => $this->footer_text,
        ];
    }
}
