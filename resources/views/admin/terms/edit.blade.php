@extends('layouts.app')
@section('title', 'Edit Term')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Edit Term</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.terms.update', $term->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Term Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $term->name }}" required>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.terms.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Update Term</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection