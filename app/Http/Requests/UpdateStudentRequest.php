<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session('user_role') === 'nurse';
    }

    public function rules(): array
    {
        $studentId = $this->route('student')?->id;

        return [
            'student_id' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9\-]+$/',
                Rule::unique('students', 'student_id')->ignore($studentId),
            ],
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
        return (new StoreStudentRequest)->messages();
    }
}
