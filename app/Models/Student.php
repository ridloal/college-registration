<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nomor_induk',
        'name',
        'phone',
        'email',
        'faculty_id',
        'major_study',
        'gpa',
        'math_score',
        'science_score'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}