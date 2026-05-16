<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::with('student')->findOrFail(session('user_id'));

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::with('student')->findOrFail(session('user_id'));

        if ($user->isStudent()) {
            return $this->updateStudentProfile($request, $user);
        }

        return $this->updateNurseProfile($request, $user);
    }

    protected function updateNurseProfile(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        session(['user_name' => $user->name]);

        return redirect()->route('profile.edit')->with('success', 'Your nurse profile has been updated.');
    }

    protected function updateStudentProfile(Request $request, User $user)
    {
        $student = $user->student;

        if (! $student) {
            return back()->withErrors(['profile' => 'Your student record could not be found. Please contact the clinic nurse.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'contact_number' => 'required|string|max:50',
            'address' => 'required|string',
            'guardian_name' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:50',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $student->update([
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
            'guardian_name' => $validated['guardian_name'],
            'emergency_contact' => $validated['emergency_contact'],
        ]);

        session(['user_name' => $user->name]);

        return redirect()->route('profile.edit')->with('success', 'Your student profile has been updated.');
    }
}
