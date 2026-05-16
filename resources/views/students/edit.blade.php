@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Edit student</h1>
                <p class="subtitle">Update profile for {{ $student->full_name }}</p>
            </div>
            <a class="btn btn-ghost" href="{{ route('students.show', $student) }}">← Back</a>
        </div>

        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="field-group">
                    <label for="student_id">Student ID</label>
                    <input id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" required>
                </div>
                <div class="field-group">
                    <label for="full_name">Full name</label>
                    <input id="full_name" name="full_name" value="{{ old('full_name', $student->full_name) }}" required>
                </div>
                <div class="field-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Choose</option>
                        <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $student->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="field-group">
                    <label for="birthdate">Birthdate</label>
                    <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}" required>
                </div>
                <div class="field-group">
                    <label for="course">Course</label>
                    <input id="course" name="course" value="{{ old('course', $student->course) }}" required>
                </div>
                <div class="field-group">
                    <label for="section">Section</label>
                    <input id="section" name="section" value="{{ old('section', $student->section) }}" required>
                </div>
                <div class="field-group">
                    <label for="contact_number">Contact number</label>
                    <input id="contact_number" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}" required>
                </div>
                <div class="field-group">
                    <label for="emergency_contact">Emergency contact</label>
                    <input id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $student->emergency_contact) }}" required>
                </div>
                <div class="field-group full">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" required>{{ old('address', $student->address) }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="guardian_name">Guardian name</label>
                    <input id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" required>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Update student</button>
                <a class="btn btn-ghost" href="{{ route('students.show', $student) }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
