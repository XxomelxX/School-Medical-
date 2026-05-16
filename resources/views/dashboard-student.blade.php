@extends('layouts.app')

@section('content')
    <div class="card card-flat">
        <div class="page-header">
            <div>
                <h1>My dashboard</h1>
                <p class="subtitle">View your health records and update your profile.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('profile.edit') }}">Edit my profile</a>
        </div>
    </div>

    @if(!$student)
        <div class="card">
            <div class="empty-state">
                <p>Your account is not linked to a student record yet.</p>
                <p class="subtitle">Please ask your clinic nurse to register you in the system, then sign up with your Student ID.</p>
            </div>
        </div>
    @else
        <div class="grid summary-grid">
            <div class="card stat-card">
                <div>
                    <h2>Student ID</h2>
                    <div class="value" style="font-size: 1.25rem;">{{ $student->student_id }}</div>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h2>Medical records</h2>
                    <div class="value">{{ $records->count() }}</div>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h2>Latest status</h2>
                    <div class="value" style="font-size: 1.1rem;">
                        @if($latestRecord)
                            <span class="badge {{ $latestRecord->medical_status === 'Healthy' ? 'success' : ($latestRecord->medical_status === 'Critical' ? 'danger' : 'warning') }}">
                                {{ $latestRecord->medical_status }}
                            </span>
                        @else
                            <span class="subtitle">No checkups yet</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>My medical records</h2>
            <p class="subtitle" style="margin-bottom: 16px;">Checkups recorded by the clinic nurse</p>

            @if($records->isEmpty())
                <div class="empty-state">
                    <p>No medical records on file yet.</p>
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
                            @foreach($records as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->checkup_date)->format('M d, Y') }}</td>
                                    <td>{{ Str::limit($record->diagnosis, 50) }}</td>
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
                                        <a href="{{ route('my-records.show', $record) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif
@endsection
