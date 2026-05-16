@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Medical Record #{{ $medicalRecord->id }}</h1>
                <p class="subtitle">
                    @if(session('user_role') === 'nurse')
                        <a href="{{ route('students.show', $medicalRecord->student) }}" style="color: var(--primary); font-weight: 700;">
                            {{ $medicalRecord->student->full_name }}
                        </a>
                    @else
                        {{ $medicalRecord->student->full_name }}
                    @endif
                    · {{ \Carbon\Carbon::parse($medicalRecord->checkup_date)->format('F j, Y') }}
                </p>
            </div>
            <div class="toolbar-actions">
                @if(session('user_role') === 'student')
                    <a class="btn btn-ghost" href="{{ url('/') }}">← Back</a>
                    <a class="btn btn-secondary" href="{{ route('my-records.pdf', $medicalRecord) }}">Download PDF</a>
                @else
                    <a class="btn btn-ghost" href="{{ route('medical-records.index') }}">← Back</a>
                    <a class="btn btn-secondary" href="{{ route('medical-records.pdf', $medicalRecord) }}">Download PDF</a>
                    <a class="btn btn-primary" href="{{ route('medical-records.edit', $medicalRecord) }}">Edit</a>
                    <form action="{{ route('medical-records.destroy', $medicalRecord) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                @endif
            </div>
        </div>

        @php
            $badge = match($medicalRecord->medical_status) {
                'Healthy' => 'success',
                'Critical' => 'danger',
                default => 'warning',
            };
        @endphp
        <p style="margin-bottom: 20px;"><span class="badge {{ $badge }}" style="font-size: 0.875rem; padding: 6px 16px;">{{ $medicalRecord->medical_status }}</span></p>

        <dl class="detail-grid">
            <div class="detail-item"><dt>Student ID</dt><dd>{{ $medicalRecord->student->student_id }}</dd></div>
            <div class="detail-item"><dt>Height</dt><dd>{{ $medicalRecord->height }}</dd></div>
            <div class="detail-item"><dt>Weight</dt><dd>{{ $medicalRecord->weight }}</dd></div>
            <div class="detail-item"><dt>Blood pressure</dt><dd>{{ $medicalRecord->blood_pressure }}</dd></div>
            <div class="detail-item"><dt>Allergies</dt><dd>{{ $medicalRecord->allergies ?: '—' }}</dd></div>
            <div class="detail-item"><dt>Medical condition</dt><dd>{{ $medicalRecord->medical_condition ?: '—' }}</dd></div>
            <div class="detail-item full" style="grid-column: 1 / -1;"><dt>Diagnosis</dt><dd>{{ $medicalRecord->diagnosis }}</dd></div>
            <div class="detail-item full" style="grid-column: 1 / -1;"><dt>Treatment</dt><dd>{{ $medicalRecord->treatment }}</dd></div>
            <div class="detail-item"><dt>Prescribed medicine</dt><dd>{{ $medicalRecord->prescribed_medicine ?: '—' }}</dd></div>
            <div class="detail-item"><dt>Notes</dt><dd>{{ $medicalRecord->notes ?: '—' }}</dd></div>
            <div class="detail-item"><dt>Attachment</dt><dd>
                @if($medicalRecord->file_attachment)
                    <a href="{{ asset('storage/' . $medicalRecord->file_attachment) }}" target="_blank" rel="noopener" style="color: var(--primary); font-weight: 700;">View file</a>
                @else
                    —
                @endif
            </dd></div>
        </dl>
    </div>
@endsection
