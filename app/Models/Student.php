<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'id',
        'nomor_induk',
        'name',
        'phone',
        'email',
        'faculty_id',
        'gpa',
        'major_study',
        'math_score',
        'science_score',
    ];
}
