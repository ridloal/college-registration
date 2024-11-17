<?php

namespace Tests\Unit\Services;

use App\Mail\RegistrationSuccessful;
use App\Models\Faculty;
use App\Models\Student;
use App\Services\Notifications\EmailNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EmailNotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sends_registration_notification(): void
    {
        Mail::fake();
        Log::shouldReceive('info')->once()->with('Registration notification sent successfully', \Mockery::any());

        $faculty = Faculty::factory()->create();
        $student = Student::factory()->create([
            'faculty_id' => $faculty->id
        ]);

        $service = new EmailNotificationService();
        $service->sendRegistrationNotification($student);

        Mail::assertSent(RegistrationSuccessful::class, function ($mail) use ($student) {
            return $mail->student->id === $student->id &&
                   $mail->hasTo($student->email);
        });
    }

    public function test_fails_to_send_registration_notification(): void
    {
        Mail::fake();
        Log::shouldReceive('error')->once()->with('Failed to send registration notification', \Mockery::any());

        $faculty = Faculty::factory()->create();
        $student = Student::factory()->create([
            'faculty_id' => $faculty->id,
            'email' => 'invalid-email'
        ]);

        $service = new EmailNotificationService();

        $this->expectException(\Exception::class);

        $service->sendRegistrationNotification($student);
    }
}