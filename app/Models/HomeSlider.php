<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'image',
        'bio',
        'experience',
        'languages',
        'education',
        'specialization',
        'phone'
    ];
}
