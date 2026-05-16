@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>My profile</h1>
                <p class="subtitle">
                    @if($user->isNurse())
                        Update your nurse account (name, email, password).
                    @else
                        Update your login details and contact information. Academic details are managed by the clinic nurse.
                    @endif
                </p>
            </div>
            <span class="badge {{ $user->isNurse() ? 'success' : 'warning' }}">
                {{ $user->isNurse() ? 'Nurse' : 'Student' }}
            </span>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <p class="sidebar-label" style="margin-bottom: 12px;">Account</p>
            <div class="form-grid">
                <div class="field-group">
                    <label for="name">Display name</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="field-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="field-group">
                    <label for="password">New password</label>
                    <input id="password" type="password" name="password" placeholder="Leave blank to keep current">
                </div>
                <div class="field-group">
                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation">
                </div>
            </div>

            @if($user->isStudent() && $user->student)
                <p class="sidebar-label" style="margin: 28px 0 12px;">Student information (read-only)</p>
                <dl class="detail-grid" style="margin-bottom: 24px;">
                    <div class="detail-item"><dt>Student ID</dt><dd>{{ $user->student->student_id }}</dd></div>
                    <div class="detail-item"><dt>Full name</dt><dd>{{ $user->student->full_name }}</dd></div>
                    <div class="detail-item"><dt>Course</dt><dd>{{ $user->student->course }}</dd></div>
                    <div class="detail-item"><dt>Section</dt><dd>{{ $user->student->section }}</dd></div>
                    <div class="detail-item"><dt>Gender</dt><dd>{{ $user->student->gender }}</dd></div>
                    <div class="detail-item"><dt>Birthdate</dt><dd>{{ \Carbon\Carbon::parse($user->student->birthdate)->format('M d, Y') }}</dd></div>
                </dl>

                <p class="sidebar-label" style="margin-bottom: 12px;">Editable contact details</p>
                <div class="form-grid">
                    <div class="field-group">
                        <label for="contact_number">Contact number</label>
                        <input id="contact_number" name="contact_number" value="{{ old('contact_number', $user->student->contact_number) }}" required>
                    </div>
                    <div class="field-group">
                        <label for="emergency_contact">Emergency contact</label>
                        <input id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $user->student->emergency_contact) }}" required>
                    </div>
                    <div class="field-group full">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" required>{{ old('address', $user->student->address) }}</textarea>
                    </div>
                    <div class="field-group full">
                        <label for="guardian_name">Guardian name</label>
                        <input id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $user->student->guardian_name) }}" required>
                    </div>
                </div>
            @elseif($user->isStudent())
                <div class="flash error" style="margin-top: 20px;">
                    Your account is not linked to a student record. Please contact the clinic nurse.
                </div>
            @endif

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Save profile</button>
                <a class="btn btn-ghost" href="{{ url('/') }}">Back to dashboard</a>
            </div>
        </form>
    </div>
@endsection
