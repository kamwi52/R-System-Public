@extends('layouts.app')
@section('title', 'Subject Management')
@section('content')
<div class="content-container">
    <div class="management-card">
        
        <!-- Header Row -->
        <div class="card-header-actions">
            <h2 class="management-title">All Subjects</h2>
            <div class="header-btns">
                <a href="{{ route('admin.subjects.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Add Subject
                </a>
            </div>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Code</th>
                        <th>Teachers Assigned</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr>
                        <td class="class-name-cell">{{ $subject->name }}</td>
                        <td><code style="color: #fbbf24;">{{ $subject->code }}</code></td>
                        <td>
                            <span class="teacher-badge">
                                {{ $subject->teachers_count }} Teachers
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-group">
                                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="act-btn btn-blue" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this subject?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn btn-red" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">No subjects found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Spacing -->
        <div style="margin-top: 20px; color: #94a3b8;">
            {{ $subjects->links() }}
        </div>
    </div>
</div>
@endsection