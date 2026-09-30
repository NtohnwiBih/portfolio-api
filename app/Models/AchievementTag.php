<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementTag extends Model
{
    protected $fillable = ['achievement_id', 'tag'];

    public $timestamps = false;
}
