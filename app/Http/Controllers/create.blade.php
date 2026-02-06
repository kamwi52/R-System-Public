@extends('layouts.app')

@section('title', 'Add New Class')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Create New Class Section</h3>
        </div>
        
        <div class="content-body">
            <form action="{{ url('/classes') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Class Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Grade 10-A" required>
                </div>

                <div class="form-group">
                    <label for="academic_session_id" class="form-label">Academic Session</label>
                    <select name="academic_session_id" id="academic_session_id" class="form-control" required>
                        <option value="">Select Session...</option>
                        @foreach($academicSessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/classes') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
