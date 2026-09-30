<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertisePrinciple extends Model
{
    protected $fillable = ['icon', 'title', 'description', 'order'];

    public $timestamps = false;
}
