<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceHighlight extends Model
{
    protected $fillable = ['experience_id', 'description', 'order'];

    public $timestamps = false;
}
