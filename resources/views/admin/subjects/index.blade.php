@extends('layouts.app')
@section('title', 'Subject Management')
@section('content')
<div class="content-container">
    <div class="management-card">
        <!-- Header Section -->
        <div class="card-header-actions">
            <h2 class="management-title">Subject Management</h2>
            <div class="action-buttons">
                <a href="{{ route('admin.subjects.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Add Subject
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('admin.subjects.index') }}" method="GET" class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search subjects..." class="search-field" value="{{ request('search') }}">
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>CODE</th>
                        <th>TEACHERS ASSIGNED</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->code }}</td>
                        <td>
                            <span class="role-badge" style="background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; color: #e2e8f0;">
                                {{ $subject->teachers_count }} Teachers
                            </span>
                        </td>
                        <td class="text-center actions-cell">
                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="edit-link"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="inline" style="display:inline;" onsubmit="return confirm('Delete this subject?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete-link"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #e2e8f0;">No subjects found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            {{ $subjects->links() }}
        </div>
    </div>
</div>
@endsection