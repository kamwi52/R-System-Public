@extends('layouts.app')
@section('title', 'Edit Subject')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Edit Subject: {{ $subject->name }}</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Subject Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Subject Code</label>
                    <input type="text" name="code" class="form-control" value="{{ $subject->code }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $subject->description }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Assign Teachers</label>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #d1d5db; padding: 10px; border-radius: 6px;">
                        @foreach($teachers as $teacher)
                            <div style="margin-bottom: 5px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="checkbox" name="teachers[]" value="{{ $teacher->id }}" 
                                        {{ $subject->teachers->contains($teacher->id) ? 'checked' : '' }}>
                                    {{ $teacher->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.subjects.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Update Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection