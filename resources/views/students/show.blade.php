@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>{{ $student->full_name }}</h1>
                <p class="subtitle">{{ $student->student_id }} · {{ $student->course }} — Section {{ $student->section }}</p>
            </div>
            <div class="toolbar-actions">
                <a class="btn btn-ghost" href="{{ route('students.index') }}">← Back</a>
                <a class="btn btn-primary" href="{{ route('medical-records.create', ['student_id' => $student->id]) }}">Add Record</a>
                <a class="btn btn-secondary" href="{{ route('students.edit', $student) }}">Edit</a>
                <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>

        <dl class="detail-grid">
            <div class="detail-item"><dt>Gender</dt><dd>{{ $student->gender }}</dd></div>
            <div class="detail-item"><dt>Birthdate</dt><dd>{{ \Carbon\Carbon::parse($student->birthdate)->format('M d, Y') }}</dd></div>
            <div class="detail-item"><dt>Contact</dt><dd>{{ $student->contact_number }}</dd></div>
            <div class="detail-item"><dt>Address</dt><dd>{{ $student->address }}</dd></div>
            <div class="detail-item"><dt>Guardian</dt><dd>{{ $student->guardian_name }}</dd></div>
            <div class="detail-item"><dt>Emergency contact</dt><dd>{{ $student->emergency_contact }}</dd></div>
        </dl>
    </div>

    <div class="card">
        <div class="page-header">
            <div>
                <h2>Medical history</h2>
                <p class="subtitle">{{ $student->medicalRecords->count() }} record(s) on file</p>
            </div>
        </div>

        @if($student->medicalRecords->isEmpty())
            <div class="empty-state">
                <p>No medical records for this student yet.</p>
                <a class="btn btn-primary btn-sm" href="{{ route('medical-records.create') }}">Add checkup record</a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Diagnosis</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->medicalRecords as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->checkup_date)->format('M d, Y') }}</td>
                                <td>{{ Str::limit($record->diagnosis, 60) }}</td>
                                <td>
                                    @php
                                        $badge = match($record->medical_status) {
                                            'Healthy' => 'success',
                                            'Critical' => 'danger',
                                            default => 'warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $record->medical_status }}</span>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('medical-records.show', $record) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
