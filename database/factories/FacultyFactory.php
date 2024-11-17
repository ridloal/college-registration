<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FacultyFactory extends Factory
{
    protected $model = Faculty::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'faculty_code' => fake()->unique()->numerify('F##'),
            'name' => fake()->unique()->randomElement([
                'Faculty of Engineering',
                'Faculty of Medicine',
                'Faculty of Economics',
                'Faculty of Law',
                'Faculty of Computer Science'
            ]),
        ];
    }
}