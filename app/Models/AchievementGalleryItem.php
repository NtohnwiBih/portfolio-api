<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementGalleryItem extends Model
{
    protected $fillable = ['achievement_id', 'title', 'subtitle', 'icon', 'media_path', 'order'];

    public $timestamps = false;

    protected $appends = ['media_url'];

    public function getMediaUrlAttribute(): ?string
    {
        return $this->media_path ? asset('storage/' . $this->media_path) : null;
    }
}
