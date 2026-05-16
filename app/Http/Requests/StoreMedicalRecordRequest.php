<?php

namespace App\Http\Requests;

use App\Models\MedicalRecord;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session('user_role') === 'nurse';
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'checkup_date' => ['required', 'date', 'before_or_equal:today'],
            'height' => ['required', 'string', 'max:20'],
            'weight' => ['required', 'string', 'max:20'],
            'blood_pressure' => ['required', 'regex:/^\d{2,3}\/\d{2,3}$/'],
            'allergies' => ['nullable', 'string', 'max:1000'],
            'medical_condition' => ['nullable', 'string', 'max:1000'],
            'diagnosis' => ['required', 'string', 'min:3', 'max:2000'],
            'treatment' => ['required', 'string', 'min:3', 'max:2000'],
            'prescribed_medicine' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'medical_status' => ['required', Rule::in(MedicalRecord::STATUSES)],
            'file_attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'checkup_date.before_or_equal' => 'Checkup date cannot be in the future.',
            'blood_pressure.regex' => 'Blood pressure must be in format like 120/80.',
            'medical_status.in' => 'Please select a valid medical status.',
            'file_attachment.mimes' => 'Attachment must be PDF, JPG, PNG, or DOCX.',
            'file_attachment.max' => 'Attachment must not exceed 2 MB.',
        ];
    }
}
