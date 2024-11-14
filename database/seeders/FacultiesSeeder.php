<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::create([
            'id' => '1',
            'faculty_code' => '100',
            'name' => 'Faculty of Engineering',
        ]);

        Faculty::create([
            'id' => '2',
            'faculty_code' => '200',
            'name' => 'Faculty of Social Sciences',
        ]);

        Faculty::create([
            'id' => '3',
            'faculty_code' => '300',
            'name' => 'Faculty of Management',
        ]);

        Faculty::create([
            'id' => '4',
            'faculty_code' => '400',
            'name' => 'Faculty of Medicine',
        ]);

        Faculty::create([
            'id' => '5',
            'faculty_code' => '500',
            'name' => 'Faculty of Doctorate',
        ]);
    }
}
