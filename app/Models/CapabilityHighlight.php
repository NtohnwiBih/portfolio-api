<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapabilityHighlight extends Model
{
    protected $fillable = ['title', 'subtitle', 'icon', 'media_path', 'link', 'order'];

    public $timestamps = false;

    protected $appends = ['media_url'];

    public function getMediaUrlAttribute(): ?string
    {
        return $this->media_path ? asset('storage/' . $this->media_path) : null;
    }
}
