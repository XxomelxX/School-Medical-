@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <h1>Students</h1>
                <p class="subtitle">Browse registered students and manage their profiles.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('students.create') }}">+ Add Student</a>
        </div>

        <form method="GET" action="{{ route('students.index') }}" class="search-bar">
            <div class="field">
                <label for="search">Search</label>
                <input id="search" type="search" name="search" value="{{ $search ?? '' }}" placeholder="Name, ID, course, or section">
            </div>
            <button class="btn btn-primary" type="submit">Search</button>
            @if($search ?? false)
                <a class="btn btn-ghost" href="{{ route('students.index') }}">Clear</a>
            @endif
        </form>

        @if($students->isEmpty())
            <div class="empty-state">
                <p>{{ ($search ?? false) ? 'No students match your search.' : 'No students registered yet.' }}</p>
                <a class="btn btn-primary" href="{{ route('students.create') }}">Add your first student</a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->course }}</td>
                                <td>{{ $student->section }}</td>
                                <td class="actions">
                                    <a href="{{ route('students.show', $student) }}">View</a>
                                    <a href="{{ route('students.edit', $student) }}">Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student and all related records?');">
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
            <div class="pagination">{{ $students->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
