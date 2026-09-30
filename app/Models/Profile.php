<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'role_title', 'hero_title', 'hero_highlight', 'hero_description',
        'photo_path', 'photo_caption', 'quote', 'quote_author',
        'email', 'phone', 'location', 'contact_intro', 'resume_path', 'footer_text',
    ];

    protected $appends = ['photo_url', 'resume_url'];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }
}
