<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('faculty')->get();
        return view('student.index', compact('students'));
    }

    public function topGPA()
    {
        $students = Student::with('faculty')
            ->orderBy('gpa', 'desc')
            ->limit(5)
            ->get();
        return view('student.top-gpa', compact('students'));
    }

    public function topRankGPA()
    {
        $students = DB::table(DB::raw("(
                SELECT 
                    students.*,
                    NTILE(10) OVER (ORDER BY gpa DESC) as percentile
                FROM students
            ) as ranked_students"))
            ->where('percentile', 1)  // Now we can safely use the alias
            ->get()
            ->map(function ($student) {
                $student->faculty = DB::table('faculties')
                    ->where('id', $student->faculty_id)
                    ->first();
                return $student;
            });

        return view('student.top-rank-gpa', compact('students'));
    }
}