<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
        }

        $this->setUserSession($user);

        $label = $user->isNurse() ? 'Nurse' : 'Student';

        return redirect('/')->with('success', 'Welcome back, '.$user->name.' ('.$label.').');
    }

    public function showRegister()
    {
        if (session()->has('user_id')) {
            return redirect('/');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in([User::ROLE_NURSE, User::ROLE_STUDENT])],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'school_student_id' => [
                Rule::requiredIf($request->role === User::ROLE_STUDENT),
                'nullable',
                'string',
            ],
        ]);

        $studentId = null;

        if ($validated['role'] === User::ROLE_STUDENT) {
            $student = Student::where('student_id', $validated['school_student_id'])
                ->whereDoesntHave('user')
                ->first();

            if (! $student) {
                return back()
                    ->withErrors(['school_student_id' => 'Student ID not found or already has an account. Ask your clinic nurse to register you first.'])
                    ->withInput();
            }

            $studentId = $student->id;

            if ($student->full_name && ! $request->filled('name')) {
                $validated['name'] = $student->full_name;
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'student_id' => $studentId,
        ]);

        $this->setUserSession($user);

        $message = $user->isNurse()
            ? 'Your nurse account has been created.'
            : 'Your student account has been linked to your school record.';

        return redirect('/')->with('success', $message);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

    protected function setUserSession(User $user): void
    {
        session()->regenerate();
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'student_id' => $user->student_id,
        ]);
    }
}
