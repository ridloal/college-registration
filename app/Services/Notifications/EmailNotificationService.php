<?php

namespace App\Services\Notifications;

use App\Mail\RegistrationSuccessful;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotificationService implements INotificationService
{
    public function sendRegistrationNotification(Student $student, string $password): void
    {
        try {
            Mail::to($student->email)
                ->send(new RegistrationSuccessful($student, $password));
            
            Log::info('Registration notification sent successfully', [
                'student_id' => $student->id,
                'email' => $student->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send registration notification', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
}