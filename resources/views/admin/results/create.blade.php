@extends('layouts.app')
@section('title', 'Add Result')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Add Student Result</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.results.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Assessment</label>
                    <select name="assessment_id" class="form-control" required>
                        <option value="">Select Assessment...</option>
                        @foreach($assessments as $assessment)
                            <option value="{{ $assessment->id }}">{{ $assessment->name }} ({{ $assessment->classSection->name ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-control" required>
                        <option value="">Select Student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->classSection->name ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Score</label>
                    <input type="number" name="score" class="form-control" step="0.01" required>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.results.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Save Result</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection