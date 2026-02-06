@extends('layouts.app')

@section('title', 'Edit Class')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Edit Class Section</h3>
        </div>
        
        <div class="content-body">
            <form action="{{ url('/classes/' . $classSection->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Class Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $classSection->name }}" required>
                </div>

                <div class="form-group">
                    <label for="academic_session_id" class="form-label">Academic Session</label>
                    <select name="academic_session_id" id="academic_session_id" class="form-control" required>
                        <option value="">Select Session...</option>
                        @foreach($academicSessions as $session)
                            <option value="{{ $session->id }}" {{ $classSection->academic_session_id == $session->id ? 'selected' : '' }}>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/classes') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Update Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection