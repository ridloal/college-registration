<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'nomor_induk' => fake()->unique()->numerify('2024#######'),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'faculty_id' => Faculty::factory(),
            'major_study' => fake()->randomElement([
                'Computer Science',
                'Information Systems',
                'Software Engineering',
                'Data Science',
                'Artificial Intelligence'
            ]),
            'gpa' => fake()->randomFloat(2, 2.5, 4.0),
            'math_score' => fake()->randomFloat(2,8,10),
            'science_score' => fake()->randomFloat(2,8,10),
        ];
    }
}