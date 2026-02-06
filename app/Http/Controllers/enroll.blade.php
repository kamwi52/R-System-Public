@extends('layouts.app')

@section('title', 'Enroll Student')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Enroll Student into {{ $classSection->name }}</h3>
        </div>
        
        <div class="content-body">
            <form action="{{ route('classes.enroll.store', $classSection->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Select Student</label>
                    <select name="student_id" class="form-control" required>
                        <option value="">-- Select a student --</option>
                        @forelse($availableStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @empty
                            <option value="" disabled>No unassigned students found</option>
                        @endforelse
                    </select>
                    <p style="margin-top: 8px; font-size: 0.85rem; color: #6b7280;">
                        Only students not currently assigned to a class are listed here.
                    </p>
                </div>

                <div class="form-actions">
                    <a href="{{ route('classes.students', $classSection->id) }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary" {{ $availableStudents->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-user-plus"></i> Enroll Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection