<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Cache::remember('settings', 3600, function () {
            return Setting::first();
        });
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::first();
        $settings->update([
            'registration_date_start' => $request->registration_date_start,
            'registration_date_end' => $request->registration_date_end,
            'quota' => $request->quota,
            'min_math_score' => $request->min_math_score,
            'min_science_score' => $request->min_science_score,
        ]);

        Cache::forget('settings');

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}