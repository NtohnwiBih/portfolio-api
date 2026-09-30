<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertiseCategoryItem extends Model
{
    protected $fillable = ['expertise_category_id', 'label', 'order'];

    public $timestamps = false;
}
