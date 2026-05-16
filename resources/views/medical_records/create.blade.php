@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Add medical record</h1>
                <p class="subtitle">Log a new student checkup and health assessment.</p>
            </div>
            <a class="btn btn-ghost" href="{{ route('medical-records.index') }}">← Back</a>
        </div>

        <form method="POST" action="{{ route('medical-records.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="full field-group">
                    <label for="student_id">Student</label>
                    <select id="student_id" name="student_id" required>
                        <option value="">Select student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ (string) old('student_id', $selectedStudentId ?? '') === (string) $student->id ? 'selected' : '' }}>
                                {{ $student->full_name }} ({{ $student->student_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label for="checkup_date">Checkup date</label>
                    <input id="checkup_date" type="date" name="checkup_date" value="{{ old('checkup_date', date('Y-m-d')) }}" required>
                </div>
                <div class="field-group">
                    <label for="medical_status">Medical status</label>
                    <select id="medical_status" name="medical_status" required>
                        <option value="">Select status</option>
                        @foreach(['Healthy','Under Observation','Needs Attention','Critical'] as $status)
                            <option value="{{ $status }}" {{ old('medical_status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field-group">
                    <label for="height">Height</label>
                    <input id="height" name="height" value="{{ old('height') }}" placeholder="e.g. 165 cm" required>
                </div>
                <div class="field-group">
                    <label for="weight">Weight</label>
                    <input id="weight" name="weight" value="{{ old('weight') }}" placeholder="e.g. 55 kg" required>
                </div>
                <div class="field-group">
                    <label for="blood_pressure">Blood pressure</label>
                    <input id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="e.g. 120/80" required>
                </div>
                <div class="field-group">
                    <label for="file_attachment">Attachment</label>
                    <input id="file_attachment" type="file" name="file_attachment" accept=".pdf,.jpg,.jpeg,.png,.docx">
                </div>

                <div class="field-group full">
                    <label for="allergies">Allergies</label>
                    <textarea id="allergies" name="allergies" rows="2">{{ old('allergies') }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="medical_condition">Medical condition</label>
                    <textarea id="medical_condition" name="medical_condition" rows="2">{{ old('medical_condition') }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="diagnosis">Diagnosis</label>
                    <textarea id="diagnosis" name="diagnosis" rows="3" required>{{ old('diagnosis') }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="treatment">Treatment</label>
                    <textarea id="treatment" name="treatment" rows="3" required>{{ old('treatment') }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="prescribed_medicine">Prescribed medicine</label>
                    <textarea id="prescribed_medicine" name="prescribed_medicine" rows="2">{{ old('prescribed_medicine') }}</textarea>
                </div>
                <div class="field-group full">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Save record</button>
                <a class="btn btn-ghost" href="{{ route('medical-records.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
