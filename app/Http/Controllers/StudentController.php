<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $students = Student::query()
            ->when($search, function ($query) use ($search) {
                $query->where('student_id', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('section', 'like', "%{$search}%");
            })
            ->orderBy('full_name')
            ->paginate(10);

        return view('students.index', compact('students', 'search'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'full_name' => 'required',
            'gender' => 'required',
            'course' => 'required',
            'section' => 'required',
            'birthdate' => 'required|date',
            'contact_number' => 'required',
            'address' => 'required',
            'guardian_name' => 'required',
            'emergency_contact' => 'required',
        ]);

        Student::create($validated);

        ActivityLog::create([
            'action' => 'Create Student',
            'description' => 'Added new student',
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['medicalRecords' => fn ($q) => $q->orderByDesc('checkup_date')]);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id,
            'full_name' => 'required',
            'gender' => 'required',
            'course' => 'required',
            'section' => 'required',
            'birthdate' => 'required|date',
            'contact_number' => 'required',
            'address' => 'required',
            'guardian_name' => 'required',
            'emergency_contact' => 'required',
        ]);

        $student->update($validated);

        ActivityLog::create([
            'action' => 'Update Student',
            'description' => 'Updated student information',
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        ActivityLog::create([
            'action' => 'Delete Student',
            'description' => 'Deleted a student record',
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
