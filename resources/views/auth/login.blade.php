@extends('layouts.app')

@section('auth_only')
@endsection

@section('content')
<div class="auth-shell">
    <div class="auth-panel">
        <div class="auth-hero">
            <h1>School Medical Record System</h1>
            <p>For clinic nurses and students. Nurses manage records; students view their own health history.</p>
            <div class="auth-features">
                <div class="auth-feature">Nurse and student accounts</div>
                <div class="auth-feature">Medical checkup tracking</div>
                <div class="auth-feature">Profile editing for each role</div>
            </div>
        </div>
        <div class="auth-form-wrap">
            <div class="auth-logo">M</div>
            <h2>Welcome back</h2>
            <p class="auth-sub">Sign in to continue to your dashboard</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@school.edu">

                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••">

                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>

            <p class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </p>
        </div>
    </div>
</div>
@endsection
