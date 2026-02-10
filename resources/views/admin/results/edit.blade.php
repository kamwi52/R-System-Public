@extends('layouts.app')
@section('title', 'Edit Result')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Edit Result</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.results.update', $result->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Assessment</label>
                    <input type="text" class="form-control" value="{{ $result->assessment->name }}" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Student</label>
                    <input type="text" class="form-control" value="{{ $result->student->name }}" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Score (Max: {{ $result->assessment->max_marks }})</label>
                    <input type="number" name="score" class="form-control" value="{{ $result->score }}" step="0.01" required>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.results.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Update Result</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection