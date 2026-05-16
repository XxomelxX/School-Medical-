@extends('layouts.app')

@section('auth_only')
@endsection

@section('content')
<div class="auth-shell">
    <div class="auth-panel">
        <div class="auth-hero">
            <h1>Create your account</h1>
            <p>Clinic nurses manage student records. Students can view their own health history and update contact details.</p>
            <div class="auth-features">
                <div class="auth-feature">Nurses: full clinic access</div>
                <div class="auth-feature">Students: own profile &amp; records</div>
                <div class="auth-feature">Secure login for both roles</div>
            </div>
        </div>
        <div class="auth-form-wrap">
            <div class="auth-logo">M</div>
            <h2>Register</h2>
            <p class="auth-sub">Choose whether you are a clinic nurse or a student</p>

            <form method="POST" action="{{ route('register') }}" id="register-form">
                @csrf

                <label for="role">I am a</label>
                <select id="role" name="role" required>
                    <option value="">Select role</option>
                    <option value="nurse" {{ old('role') === 'nurse' ? 'selected' : '' }}>Clinic Nurse</option>
                    <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                </select>

                <div id="student-id-field" style="display: {{ old('role') === 'student' ? 'block' : 'none' }};">
                    <label for="school_student_id">School Student ID</label>
                    <input id="school_student_id" name="school_student_id" value="{{ old('school_student_id') }}" placeholder="e.g. 2024-001">
                    <p style="font-size: 0.8125rem; color: var(--muted); margin-top: 6px;">Your nurse must add you to the system first.</p>
                </div>

                <label for="name">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>

                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>

                <button type="submit" class="btn btn-primary">Create account</button>
            </form>

            <p class="auth-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>
</div>
<script>
    document.getElementById('role')?.addEventListener('change', function () {
        const field = document.getElementById('student-id-field');
        const input = document.getElementById('school_student_id');
        if (this.value === 'student') {
            field.style.display = 'block';
            input.required = true;
        } else {
            field.style.display = 'none';
            input.required = false;
        }
    });
    document.getElementById('role')?.dispatchEvent(new Event('change'));
</script>
@endsection
