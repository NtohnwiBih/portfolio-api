<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'type', 'short_description', 'description',
        'tech_stack', 'cover_image_path', 'is_featured', 'status', 'order',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
    ];

    protected $appends = ['cover_image_url'];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = static::uniqueSlug($project->title);
            }
        });
    }

    public static function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-" . $i++;
        }
        return $slug;
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image_path ? asset('storage/' . $this->cover_image_path) : null;
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }

    public function links()
    {
        return $this->hasMany(ProjectLink::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}