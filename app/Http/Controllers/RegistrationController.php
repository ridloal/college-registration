<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\User;
use App\Services\Notifications\INotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class RegistrationController extends Controller
{
    public function __construct(
        private INotificationService $notificationService
    ) {}

    public function index()
    {
        $faculties = Cache::remember('faculties', 3600, function () {
            return Faculty::all();
        });
        return view('registration.index', compact('faculties'));
    }

    public function store(RegistrationRequest $request)
    {
        $student = null;
        $password = '';

        DB::transaction(function () use ($request, &$student, &$password) {
            // Create new student
            $student = Student::create([
                'id' => Str::uuid(),
                'nomor_induk' => $this->generateNomorInduk($request->faculty_id),
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'faculty_id' => $request->faculty_id,
                'gpa' => 0,
                'major_study' => $request->major_study,
                'math_score' => $request->math_score,
                'science_score' => $request->science_score,
            ]);

            $password = $this->createUserCredentials($student);

        });
        
        // Send notification
        if ($student) {
            try {
                $this->notificationService->sendRegistrationNotification($student, $password);
            } catch (\Exception $e) {
                Log::error('Registration notification failed', [
                    'student_id' => $student->id,
                    'error' => $e->getMessage()
                ]);
                // Continue with registration process even if notification fails
            }
        }

        return redirect()->route('registration.index')
            ->with('success', 'Registration submitted successfully! We will review your application.');
    }

    private function generateNomorInduk($faculty_id)
    {
        $maxRetries = 5;
        $attempts = 0;

        while ($attempts < $maxRetries) {
            try {
                return DB::transaction(function () use ($faculty_id) {
                    $faculty = Faculty::find($faculty_id);
                    $studentCount = Student::where('faculty_id', $faculty_id)->lockForUpdate()->count();
                    return date('Y') . $faculty->faculty_code . str_pad($studentCount + 1, 4, '0', STR_PAD_LEFT);
                });
            } catch (\Exception $e) {
                $attempts++;
                Log::warning("Attempt $attempts: Failed to generate nomor induk due to: " . $e->getMessage());

                if ($attempts >= $maxRetries) {
                    throw $e;
                }

                // Optional: Add a short delay before retrying
                usleep(100000); // 100ms
            }
        }
    }

    private function createUserCredentials(Student $student): string
    {
        $password = Str::random(8);
        // Create user credentials
        $user =  User::create([
            'student_id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'password' => Hash::make($password),
            'role' => 'student',
        ]);
        
        if($user) {
            return $password;
        } else {
            throw new \Exception('Failed to create user credentials');
        }
    }
}