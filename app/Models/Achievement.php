<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['title', 'subtitle', 'description', 'icon', 'metric_label', 'order'];

    public function tags()
    {
        return $this->hasMany(AchievementTag::class);
    }

    public function galleryItems()
    {
        return $this->hasMany(AchievementGalleryItem::class)->orderBy('order');
    }
}
