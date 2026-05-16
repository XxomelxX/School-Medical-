@extends('layouts.app')

@section('content')
    <div class="card card-flat">
        <div class="page-header">
            <div>
                <h1>Dashboard</h1>
                <p class="subtitle">Overview of students, medical records, and recent clinic activity.</p>
            </div>
            <div class="toolbar-actions">
                <a class="btn btn-primary" href="{{ route('students.create') }}">+ Add Student</a>
            </div>
        </div>
    </div>

    <div class="grid summary-grid">
        <div class="card stat-card">
            <div>
                <h2>Total Students</h2>
                <div class="value">{{ $students }}</div>
                <p class="hint">Registered in the system</p>
            </div>
        </div>
        <div class="card stat-card">
            <div>
                <h2>Medical Records</h2>
                <div class="value">{{ $records }}</div>
                <p class="hint">All checkup entries</p>
            </div>
        </div>
        <div class="card stat-card">
            <div>
                <h2>Healthy</h2>
                <div class="value">{{ $healthyCount }}</div>
                <p class="hint">Students marked healthy</p>
            </div>
        </div>
        <div class="card stat-card">
            <div>
                <h2>Needs Attention</h2>
                <div class="value">{{ $attentionCount }}</div>
                <p class="hint">Critical or under observation</p>
            </div>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
        <div class="card">
            <h2>Recent checkups</h2>
            <p class="subtitle" style="margin-bottom: 16px;">Latest medical record entries</p>
            @if($recentRecords->isEmpty())
                <div class="empty-state">
                    <p>No medical records yet.</p>
                    <a class="btn btn-primary btn-sm" href="{{ route('medical-records.create') }}">Add first record</a>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRecords as $record)
                                <tr>
                                    <td>
                                        <a href="{{ route('medical-records.show', $record) }}" style="color: var(--primary); font-weight: 700;">
                                            {{ $record->student->full_name }}
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($record->checkup_date)->format('M d, Y') }}</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p style="margin-top: 16px;">
                    <a href="{{ route('medical-records.index') }}" style="color: var(--primary); font-weight: 700;">View all records →</a>
                </p>
            @endif
        </div>

        <div class="card">
            <h2>Recent activity</h2>
            <p class="subtitle" style="margin-bottom: 8px;">System actions log</p>
            @if($recentActivity->isEmpty())
                <div class="empty-state">
                    <p>No activity recorded yet.</p>
                </div>
            @else
                <ul class="activity-list">
                    @foreach($recentActivity as $log)
                        <li>
                            <span class="activity-dot"></span>
                            <div style="flex: 1;">
                                <strong>{{ $log->action }}</strong>
                                <span>{{ $log->description }}</span>
                            </div>
                            <time>{{ $log->created_at->diffForHumans() }}</time>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="card">
        <h2>Quick actions</h2>
        <p class="subtitle" style="margin-bottom: 20px;">Jump to common tasks</p>
        <div class="quick-actions">
            <a class="quick-action" href="{{ route('students.create') }}">Add Student</a>
            <a class="quick-action" href="{{ route('medical-records.create') }}">Add Record</a>
            <a class="quick-action" href="{{ route('students.index') }}">Browse Students</a>
            <a class="quick-action" href="{{ route('medical-records.index') }}">Browse Records</a>
        </div>
    </div>
@endsection
