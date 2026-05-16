@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Create student</h1>
                <p class="subtitle">All fields are validated before saving (unique ID, valid dates, contact format).</p>
            </div>
            <a class="btn btn-ghost" href="{{ route('students.index') }}">← Back</a>
        </div>

        <form method="POST" action="{{ route('students.store') }}" novalidate>
            @csrf
            <div class="form-grid">
                <div class="field-group">
                    <label for="student_id">Student ID</label>
                    <input id="student_id" name="student_id" value="{{ old('student_id') }}" class="@error('student_id') invalid @enderror" required>
                    <p class="form-hint">Letters, numbers, and hyphens only. Must be unique.</p>
                    @include('partials.field-error', ['field' => 'student_id'])
                </div>
                <div class="field-group">
                    <label for="full_name">Full name</label>
                    <input id="full_name" name="full_name" value="{{ old('full_name') }}" class="@error('full_name') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'full_name'])
                </div>
                <div class="field-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="@error('gender') invalid @enderror" required>
                        <option value="">Choose</option>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @include('partials.field-error', ['field' => 'gender'])
                </div>
                <div class="field-group">
                    <label for="birthdate">Birthdate</label>
                    <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" class="@error('birthdate') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'birthdate'])
                </div>
                <div class="field-group">
                    <label for="course">Course</label>
                    <input id="course" name="course" value="{{ old('course') }}" class="@error('course') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'course'])
                </div>
                <div class="field-group">
                    <label for="section">Section</label>
                    <input id="section" name="section" value="{{ old('section') }}" class="@error('section') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'section'])
                </div>
                <div class="field-group">
                    <label for="contact_number">Contact number</label>
                    <input id="contact_number" name="contact_number" value="{{ old('contact_number') }}" class="@error('contact_number') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'contact_number'])
                </div>
                <div class="field-group">
                    <label for="emergency_contact">Emergency contact</label>
                    <input id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" class="@error('emergency_contact') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'emergency_contact'])
                </div>
                <div class="field-group full">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" class="@error('address') invalid @enderror" required>{{ old('address') }}</textarea>
                    @include('partials.field-error', ['field' => 'address'])
                </div>
                <div class="field-group full">
                    <label for="guardian_name">Guardian name</label>
                    <input id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" class="@error('guardian_name') invalid @enderror" required>
                    @include('partials.field-error', ['field' => 'guardian_name'])
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Save student</button>
                <a class="btn btn-ghost" href="{{ route('students.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
