@extends('layouts.app')
@section('title', 'Select Students for Report')
@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h3>Generate Reports</h3>
            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                {{ $classSection->name }} &bull; {{ $term->name }} &bull; {{ $session->name }}
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <form action="{{ route('admin.final-reports.generate') }}" method="POST">
                @csrf
                <input type="hidden" name="academic_session_id" value="{{ $session->id }}">
                <input type="hidden" name="class_section_id" value="{{ $classSection->id }}">
                <input type="hidden" name="term_id" value="{{ $term->id }}">
                <button type="submit" class="btn-primary"><i class="fas fa-file-archive"></i> Download All (ZIP)</button>
            </form>
            <a href="{{ route('admin.final-reports.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $student->name }}</div>
                    </td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <a href="{{ route('admin.final-reports.generate-single', ['student_id' => $student->id, 'class_id' => $classSection->id, 'term_id' => $term->id]) }}" class="btn-primary" target="_blank" style="padding: 6px 12px; font-size: 0.85rem;">
                            <i class="fas fa-file-pdf"></i> Generate PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 30px; color: #6b7280;">
                        No students found in this class.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection