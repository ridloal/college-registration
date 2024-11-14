<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'id' => '0',
            'registration_date_start' => '2024-12-01',
            'registration_date_end' => '2024-12-31',
            'quota' => 100,
            'min_math_score' => '8',
            'min_science_score' => '8',
        ]);
    }
}
