<?php

namespace Tests\Unit\Controllers;

use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    private Faculty $faculty;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create fresh schema for each test
        $this->artisan('migrate');

        // Create faculty
        $this->faculty = Faculty::factory()->create([
            'faculty_code' => 'CS'
        ]);

        // Create and authenticate user
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // Disable middleware
        $this->withoutMiddleware();
    }

    public function test_index_displays_all_students(): void
    {
        // Create test students
        $students = Student::factory()->count(3)->create([
            'faculty_id' => $this->faculty->id
        ]);

        $response = $this->get('/student');

        $response->assertStatus(200);
        $response->assertViewIs('student.index');
        $response->assertViewHas('students');

        // Verify all students are present in the response
        $responseStudents = $response->viewData('students');
        $this->assertEquals($students->count(), $responseStudents->count());
        
        foreach ($students as $student) {
            $this->assertTrue($responseStudents->contains('id', $student->id));
        }
    }

    public function test_top_gpa_displays_five_students(): void
    {
        // Create 10 students with different GPAs
        $students = [];
        for ($i = 0; $i < 10; $i++) {
            $students[] = Student::factory()->create([
                'faculty_id' => $this->faculty->id,
                'gpa' => 4.0 - ($i * 0.1)  // GPAs from 4.0 down to 3.1
            ]);
        }

        $response = $this->get('/student/top-gpa');

        $response->assertStatus(200);
        $response->assertViewIs('student.top-gpa');
        $response->assertViewHas('students');

        // Verify only top 5 students are returned
        $topStudents = $response->viewData('students');
        $this->assertEquals(5, $topStudents->count());
        
        // Verify they're in correct order (highest GPA first)
        $previousGPA = 5.0;
        foreach ($topStudents as $student) {
            $this->assertLessThan($previousGPA, $student->gpa);
            $previousGPA = $student->gpa;
        }
    }

    public function test_top_rank_gpa_displays_top_percentile(): void
    {
        // Create 100 students with varying GPAs to test percentile calculation
        for ($i = 0; $i < 100; $i++) {
            Student::factory()->create([
                'faculty_id' => $this->faculty->id,
                'gpa' => 4.0 - ($i * 0.02)  // GPAs from 4.0 down to 2.02
            ]);
        }

        $response = $this->get('/student/top-rank-gpa');

        $response->assertStatus(200);
        $response->assertViewIs('student.top-rank-gpa');
        $response->assertViewHas('students');

        // Verify only top 10% students are returned (percentile = 1)
        $topStudents = $response->viewData('students');
        $this->assertLessThanOrEqual(10, $topStudents->count());  // Should be approximately 10% of total

        // Verify all returned students have high GPAs
        $lowestTopGPA = Student::orderBy('gpa', 'desc')
            ->skip(9)  // Skip first 10% (rounded down from 100 students)
            ->first()
            ->gpa;

        foreach ($topStudents as $student) {
            $this->assertGreaterThanOrEqual($lowestTopGPA, $student->gpa);
        }
    }

    public function test_empty_student_list(): void
    {
        $response = $this->get('/student');

        $response->assertStatus(200);
        $response->assertViewIs('student.index');
        $response->assertViewHas('students');

        $students = $response->viewData('students');
        $this->assertEquals(0, $students->count());
    }

    public function test_top_gpa_with_empty_student_list(): void
    {
        $response = $this->get('/student/top-gpa');

        $response->assertStatus(200);
        $response->assertViewIs('student.top-gpa');
        $response->assertViewHas('students');

        $students = $response->viewData('students');
        $this->assertEquals(0, $students->count());
    }

    public function test_top_rank_gpa_with_empty_student_list(): void
    {
        $response = $this->get('/student/top-rank-gpa');

        $response->assertStatus(200);
        $response->assertViewIs('student.top-rank-gpa');
        $response->assertViewHas('students');

        $students = $response->viewData('students');
        $this->assertEquals(0, $students->count());
    }

    public function test_students_are_eager_loaded_with_faculty(): void
    {
        // Create students
        Student::factory()->count(3)->create([
            'faculty_id' => $this->faculty->id
        ]);

        // Use DB::enableQueryLog() to verify eager loading
        DB::enableQueryLog();
        
        $response = $this->get('/student');
        
        $queries = DB::getQueryLog();
        
        // Should see only 2 queries: one for students with faculty eager loading
        // and one for faculty
        $this->assertCount(2, $queries);
        
        DB::disableQueryLog();
    }
}