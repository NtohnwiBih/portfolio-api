<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceSnapshot extends Model
{
    protected $fillable = ['experience_id', 'title', 'subtitle', 'icon', 'image_path', 'order'];

    public $timestamps = false;

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
