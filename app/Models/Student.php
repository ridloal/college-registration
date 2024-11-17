<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
