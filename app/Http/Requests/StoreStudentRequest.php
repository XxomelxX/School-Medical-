<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session('user_role') === 'nurse';
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:students,student_id'],
            'full_name' => ['required', 'string', 'min:2', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'course' => ['required', 'string', 'max:100'],
            'section' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date', 'before:today', 'after:1900-01-01'],
            'contact_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'address' => ['required', 'string', 'min:5', 'max:500'],
            'guardian_name' => ['required', 'string', 'min:2', 'max:255'],
            'emergency_contact' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.regex' => 'Student ID may only contain letters, numbers, and hyphens.',
            'student_id.unique' => 'This Student ID is already registered.',
            'birthdate.before' => 'Birthdate must be in the past.',
            'contact_number.regex' => 'Enter a valid contact number (digits, spaces, +, -, parentheses).',
            'emergency_contact.regex' => 'Enter a valid emergency contact number.',
        ];
    }
}
