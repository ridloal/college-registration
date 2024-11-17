<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;

class RegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $settings = Setting::first();
        
        // Check if registration is open
        $today = Carbon::now()->format('Y-m-d');
        $startDate = Carbon::parse($settings->registration_date_start)->format('Y-m-d');
        $endDate = Carbon::parse($settings->registration_date_end)->format('Y-m-d');
        
        if ($today < $startDate || $today > $endDate) {
            return [
                'registration_closed' => 'required',
            ];
        }

        // Count existing students in the faculty
        $studentCount = Student::where('faculty_id', $this->faculty_id)->count();
        if ($studentCount >= $settings->quota) {
            return [
                'quota_exceeded' => 'required',
            ];
        }

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email',
            'faculty_id' => 'required|exists:faculties,id',
            'major_study' => 'required|string|max:255',
            'math_score' => [
                'required',
                'numeric',
                'min:0',
                'max:10',
                function ($attribute, $value, $fail) use ($settings) {
                    if ($value < $settings->min_math_score) {
                        $fail("Math score must be at least {$settings->min_math_score}");
                    }
                },
            ],
            'science_score' => [
                'required',
                'numeric',
                'min:0',
                'max:10',
                function ($attribute, $value, $fail) use ($settings) {
                    if ($value < $settings->min_science_score) {
                        $fail("Science score must be at least {$settings->min_science_score}");
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'registration_closed' => 'Registration is currently closed.',
            'quota_exceeded' => 'Selected faculty has reached maximum quota.',
        ];
    }
}
