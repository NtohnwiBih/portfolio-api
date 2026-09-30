<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertiseCategory extends Model
{
    protected $fillable = ['icon', 'title', 'order'];

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(ExpertiseCategoryItem::class)->orderBy('order');
    }
}
