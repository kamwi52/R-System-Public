@extends('layouts.app')
@section('title', 'Grading Scales')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Grading Scales</h3>
        <a href="{{ route('admin.grading-scales.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add Grading Scale
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Grades Defined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scales as $scale)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $scale->name }}</div>
                    </td>
                    <td>{{ $scale->grades_count }} Grades</td>
                    <td>
                        <a href="{{ route('admin.grading-scales.edit', $scale->id) }}" class="action-btn" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.grading-scales.destroy', $scale->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this grading scale?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" style="background:none;border:none;cursor:pointer;color:#ef4444;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align: center; padding: 30px;">No grading scales found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px;">
        {{ $scales->links() }}
    </div>
</div>
@endsection