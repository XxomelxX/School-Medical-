@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Medical Records</h1>
                <p class="subtitle">Track student checkups, diagnoses, and health status.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('medical-records.create') }}">+ Add Record</a>
        </div>

        <form method="GET" action="{{ route('medical-records.index') }}" class="search-bar">
            <div class="field">
                <label for="search">Search</label>
                <input id="search" type="search" name="search" value="{{ $search ?? '' }}" placeholder="Student name or ID">
            </div>
            <div class="field" style="max-width: 200px;">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">All statuses</option>
                    @foreach($statuses as $option)
                        <option value="{{ $option }}" {{ ($status ?? '') === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Filter</button>
            @if(($search ?? false) || ($status ?? false))
                <a class="btn btn-ghost" href="{{ route('medical-records.index') }}">Clear</a>
            @endif
        </form>

        @if($records->isEmpty())
            <div class="empty-state">
                <p>{{ ($search ?? false) || ($status ?? false) ? 'No records match your filters.' : 'No medical records yet.' }}</p>
                <a class="btn btn-primary" href="{{ route('medical-records.create') }}">Add first record</a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Checkup</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td>#{{ $record->id }}</td>
                                <td>
                                    <strong>{{ $record->student->full_name }}</strong><br>
                                    <span style="font-size: 0.8125rem; color: var(--muted);">{{ $record->student->student_id }}</span>
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
                                <td class="actions">
                                    <a href="{{ route('medical-records.show', $record) }}">View</a>
                                    <a href="{{ route('medical-records.edit', $record) }}">Edit</a>
                                    <form action="{{ route('medical-records.destroy', $record) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="link-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $records->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
