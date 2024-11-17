<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_code',
        'name'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}