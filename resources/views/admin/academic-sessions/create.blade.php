@extends('layouts.app')
@section('title', 'Create Academic Session')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Add New Academic Session</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.academic-sessions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Session Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. 2023-2024" required>
                </div>
                <div style="display: flex; gap: 20px;">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="is_current" value="1">
                        <span style="font-weight: 600; color: #374151;">Set as Current Session</span>
                    </label>
                    <p style="font-size: 0.85rem; color: #6b7280; margin-top: 5px;">This will automatically unset any other current session.</p>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.academic-sessions.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Create Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection