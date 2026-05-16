@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Create student</h1>
                <p class="subtitle">Register a new student in the medical system.</p>
            </div>
            <a class="btn btn-ghost" href="{{ route('students.index') }}">← Back</a>
        </div>

        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="form-grid">
                <div class="field-group">
                    <label for="student_id">Student ID</label>
                    <input id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                </div>
                <div class="field-group">
                    <label for="full_name">Full name</label>
                    <input id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                </div>
                <div class="field-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Choose</option>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="field-group">
                    <label for="birthdate">Birthdate</label>
                    <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" required>
                </div>
                <div class="field-group">
                    <label for="course">Course</label>
                    <input id="course" name="course" value="{{ old('course') }}" required>
                </div>
                <div class="field-group">
                    <label for="section">Section</label>
                    <input id="section" name="section" value="{{ old('section') }}" required>
                </div>
                <div class="field-group">
                    <label for="contact_number">Contact number</label>
                    <input id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                </div>
                <div class="field-group">
                    <label for="emergency_contact">Emergency contact</label>
                    <input id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
                </div>
                <div class="field-group full">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="guardian_name">Guardian name</label>
                    <input id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" required>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Save student</button>
                <a class="btn btn-ghost" href="{{ route('students.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
