@extends('layouts.app')

@section('title', 'Subjects - ' . $classSection->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Manage Subjects for {{ $classSection->name }}</h3>
            </div>
            <a href="{{ url('/classes') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Classes
            </a>
        </div>
        
        <div class="content-body" style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
            <form action="{{ route('classes.subjects.store', $classSection->id) }}" method="POST" style="display: flex; gap: 15px; align-items: flex-end;">
                @csrf
                <div style="flex: 1;">
                    <label class="form-label">Subject</label>
                    <select name="subject_id" class="form-control" required>
                        <option value="">Select Subject...</option>
                        @foreach($allSubjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Assign Teacher</label>
                    <select name="teacher_id" class="form-control" required>
                        <option value="">Select Teacher...</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary" style="margin-bottom: 2px;">
                    <i class="fas fa-plus"></i> Assign
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Code</th>
                        <th>Assigned Teacher</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classSection->subjects as $subject)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #111827;">{{ $subject->name }}</div>
                        </td>
                        <td>{{ $subject->code ?? '-' }}</td>
                        <td>
                            @php
                                $assignedTeacher = $teachers->firstWhere('id', $subject->pivot->teacher_id);
                            @endphp
                            {{ $assignedTeacher->name ?? 'Unknown' }}
                        </td>
                        <td>
                            <form action="{{ route('classes.subjects.remove', [$classSection->id, $subject->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Remove this subject from the class?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Remove Subject" style="background:none;border:none;cursor:pointer;color:#ef4444;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 30px;">No subjects assigned to this class yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection