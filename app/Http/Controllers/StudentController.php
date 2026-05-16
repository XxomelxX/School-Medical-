<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
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

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        Student::create($validated);

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

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
