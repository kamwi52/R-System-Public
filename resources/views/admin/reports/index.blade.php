@extends('layouts.app')
@section('title', 'Generate Reports')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Generate Final Reports</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.final-reports.show-students') }}" method="GET">
                
                <div class="form-group">
                    <label class="form-label">Academic Session</label>
                    <select name="academic_session_id" class="form-control" required>
                        <option value="">Select Session...</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Class</label>
                    <select name="class_section_id" class="form-control" required>
                        <option value="">Select Class...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Term</label>
                    <select name="term_id" class="form-control" required>
                        <option value="">Select Term...</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}">{{ $term->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-list"></i> Get Student List
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection