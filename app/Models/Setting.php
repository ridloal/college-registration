<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'id',
        'registration_date_start',
        'registration_date_end',
        'quota',
        'min_math_score',
        'min_science_score',
    ];
}
