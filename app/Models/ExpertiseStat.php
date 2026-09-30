<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertiseStat extends Model
{
    protected $fillable = ['value', 'label', 'order'];

    public $timestamps = false;
}