<?php

namespace App\Http\Requests;

use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $settings = Cache::remember('settings', 3600, function () {
            return Setting::first();
        });
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:20',
            'faculty_id' => 'required|exists:faculties,id',
            'major_study' => 'required|string|max:255',
            'math_score' => ['required', 'numeric', 'min:' . $settings->min_math_score],
            'science_score' => ['required', 'numeric', 'min:' . $settings->min_science_score],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $settings = Cache::remember('settings', 3600, function () {
                return Setting::first();
            });
            $now = Carbon::now();
            
            // Check registration period
            $start = Carbon::parse($settings->registration_date_start);
            $end = Carbon::parse($settings->registration_date_end);
            
            if ($now->lt($start) || $now->gt($end)) {
                $validator->errors()->add(
                    'registration_date',
                    'Registration is not open yet.'
                );
            }

            // Check quota
            $currentCount = Student::where('faculty_id', $this->faculty_id)->count();
            if ($currentCount >= $settings->quota) {
                $validator->errors()->add(
                    'quota',
                    'Registration quota for this faculty is full.'
                );
            }
        });
    }

    public function messages(): array
    {
        $settings = Cache::remember('settings', 3600, function () {
            return Setting::first();
        });
        
        return [
            'math_score.min' => 'Math score must be at least ' . $settings->min_math_score . '.',
            'science_score.min' => 'Science score must be at least ' . $settings->min_science_score . '.',
        ];
    }
}