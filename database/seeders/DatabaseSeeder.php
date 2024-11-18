<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //run AdminSeeder::class;
        $this->call(AdminSeeder::class);
        $this->call(FacultiesSeeder::class);
        $this->call(SettingsSeeder::class);

        for ($i = 0; $i < 80; $i++) {
            Student::factory()->create([
                'faculty_id' => rand(1, 5),
                'gpa' => 4.0 - ($i * 0.02)  // GPAs from 4.0 down to 2.02
            ]);
        }
    }
}
