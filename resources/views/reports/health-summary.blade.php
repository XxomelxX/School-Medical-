@extends('layouts.app')

@section('content')
    <div class="card card-flat">
        <div class="page-header">
            <div>
                <h1>Health status summary</h1>
                <p class="subtitle">See how many medical records fall under each health status — useful for clinic monitoring.</p>
            </div>
        </div>
    </div>

    <div class="grid summary-grid">
        <div class="card stat-card">
            <div>
                <h2>Total students</h2>
                <div class="value">{{ $totalStudents }}</div>
            </div>
        </div>
        <div class="card stat-card">
            <div>
                <h2>Students with records</h2>
                <div class="value">{{ $studentsWithRecords }}</div>
            </div>
        </div>
        <div class="card stat-card">
            <div>
                <h2>Total checkups</h2>
                <div class="value">{{ $totalRecords }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Records by medical status</h2>
        <p class="subtitle" style="margin-bottom: 20px;">Count of checkup entries per status category</p>

        @if($totalRecords === 0)
            <div class="empty-state">
                <p>No medical records yet. Add checkups to see the summary.</p>
                <a class="btn btn-primary btn-sm" href="{{ route('medical-records.create') }}">Add record</a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Medical status</th>
                            <th>Number of records</th>
                            <th>Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statusCounts as $status => $count)
                            <tr>
                                <td>
                                    @php
                                        $badge = match($status) {
                                            'Healthy' => 'success',
                                            'Critical' => 'danger',
                                            default => 'warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $status }}</span>
                                </td>
                                <td><strong>{{ $count }}</strong></td>
                                <td>{{ $totalRecords > 0 ? round(($count / $totalRecords) * 100) : 0 }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if($needsAttention->isNotEmpty())
        <div class="card">
            <h2>Recent cases needing attention</h2>
            <p class="subtitle" style="margin-bottom: 16px;">Latest checkups marked Critical, Needs Attention, or Under Observation</p>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($needsAttention as $record)
                            <tr>
                                <td>{{ $record->student->full_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($record->checkup_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge {{ $record->medical_status === 'Critical' ? 'danger' : 'warning' }}">
                                        {{ $record->medical_status }}
                                    </span>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('medical-records.show', $record) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
