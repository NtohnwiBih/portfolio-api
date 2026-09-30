<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['role_title', 'company', 'start_date', 'end_date', 'is_current', 'order'];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'is_current' => 'boolean',
    ];

    public function highlights()
    {
        return $this->hasMany(ExperienceHighlight::class)->orderBy('order');
    }

    public function snapshots()
    {
        return $this->hasMany(ExperienceSnapshot::class)->orderBy('order');
    }
}
