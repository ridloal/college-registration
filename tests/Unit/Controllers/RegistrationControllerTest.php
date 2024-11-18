<?php

namespace Tests\Unit\Controllers;

use App\Models\Faculty;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use App\Services\Notifications\INotificationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    private Setting $settings;
    private Faculty $faculty;

    protected function setUp(): void
    {
        parent::setUp();

        // Create fresh schema for each test
        $this->artisan('migrate');

        // Mock notification service
        $this->mock(INotificationService::class, function ($mock) {
            $mock->shouldReceive('sendRegistrationNotification')->andReturn(null);
        });

        // Create basic settings
        $this->settings = Setting::create([
            'id' => \Str::uuid(),
            'registration_date_start' => '2024-12-01',
            'registration_date_end' => '2024-12-31',
            'quota' => 100,
            'min_math_score' => 80,
            'min_science_score' => 80,
        ]);

        // Create faculty
        $this->faculty = Faculty::factory()->create();

        // Authenticate user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Disable middleware
        $this->withoutMiddleware();
    }

    public function test_cannot_register_outside_registration_period(): void
    {
        // Set current date outside registration period
        Carbon::setTestNow('2024-11-30');

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => 85,
            'science_score' => 85,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['registration_date' => 'Registration is not open yet.']);
    }

    public function test_cannot_register_when_quota_is_full(): void
    {
        Carbon::setTestNow('2024-12-01');

        // Fill the quota
        Student::factory()->count($this->settings->quota)->create([
            'faculty_id' => $this->faculty->id
        ]);

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => 85,
            'science_score' => 85,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quota' => 'Registration quota for this faculty is full.']);
    }

    public function test_cannot_register_with_low_math_score(): void
    {
        Carbon::setTestNow('2024-12-01');

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => 75, // Below minimum
            'science_score' => 85,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['math_score' => 'Math score must be at least 80.']);
    }

    public function test_cannot_register_with_low_science_score(): void
    {
        Carbon::setTestNow('2024-12-01');

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => 85,
            'science_score' => 75, // Below minimum
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['science_score' => 'Science score must be at least 80.']);
    }

    public function test_successful_registration(): void
    {
        Carbon::setTestNow('2024-12-01');

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => 85,
            'science_score' => 85,
        ]);

        $response->assertStatus(302); // Redirect after success
        $response->assertRedirect(route('registration.index'));
        $response->assertSessionHas('success');

        // Verify student was created
        $this->assertDatabaseHas('students', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'faculty_id' => $this->faculty->id,
            'math_score' => 85,
            'science_score' => 85,
        ]);
    }

    public function test_nomor_induk_generation(): void
    {
        Carbon::setTestNow('2024-12-01');

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => 85,
            'science_score' => 85,
        ]);

        $student = Student::where('email', 'john@example.com')->first();
        
        // Format: YYYY + faculty_code + sequential_number
        $expected_format = '/^2024' . $this->faculty->faculty_code . '\d{4}$/';
        $this->assertMatchesRegularExpression($expected_format, $student->nomor_induk);
    }

    public function test_concurrent_registration_generates_unique_nomor_induk(): void
    {
        Carbon::setTestNow('2024-12-01');

        // Simulate multiple concurrent registrations
        $promises = [];
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/registration', [
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'phone' => "123456789$i",
                'faculty_id' => $this->faculty->id,
                'major_study' => 'Computer Science',
                'math_score' => 85,
                'science_score' => 85,
            ]);
        }

        // Verify all nomor_induk are unique
        $nomor_induks = Student::pluck('nomor_induk')->toArray();
        $this->assertEquals(count($nomor_induks), count(array_unique($nomor_induks)));
    }

    public function test_sql_injection_protection(): void
    {
        Carbon::setTestNow('2024-12-01');

        $response = $this->postJson('/registration', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'faculty_id' => $this->faculty->id,
            'major_study' => 'Computer Science',
            'math_score' => '85; DROP TABLE students;', // Attempt SQL injection
            'science_score' => 85,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['math_score' => 'The math score field must be a number.']);
    }

}