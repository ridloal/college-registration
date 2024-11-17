<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    protected $fillable = [
        'id',
        'faculty_code',
        'name',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
