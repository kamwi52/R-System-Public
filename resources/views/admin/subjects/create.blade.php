@extends('layouts.app')
@section('title', 'Create Subject')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Add New Subject</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Subject Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Subject Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Assign Teachers (Optional)</label>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #d1d5db; padding: 10px; border-radius: 6px;">
                        @foreach($teachers as $teacher)
                            <div style="margin-bottom: 5px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" name="teachers[]" value="{{ $teacher->id }}">
                                    {{ $teacher->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.subjects.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Create Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection