@extends('layouts.app')
@section('title', 'Subject Management')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>All Subjects</h3>
        <a href="{{ route('admin.subjects.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add Subject
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Teachers Assigned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $subject->name }}</div>
                    </td>
                    <td>{{ $subject->code }}</td>
                    <td>
                        <span style="background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 99px; font-size: 12px; font-weight: 600;">
                            {{ $subject->teachers_count }} Teachers
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="action-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this subject?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Delete" style="background:none;border:none;cursor:pointer;color:#ef4444;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 30px;">No subjects found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px;">
        {{ $subjects->links() }}
    </div>
</div>
@endsection