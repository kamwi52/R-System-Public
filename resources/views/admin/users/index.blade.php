@extends('layouts.app')
@section('title', 'User Management')
@section('content')
<div class="content-container">
    <div class="management-card">
        
        <!-- Header Row -->
        <div class="card-header-actions">
            <h2 class="management-title">All Users</h2>
            <div class="header-btns">
                <a href="{{ route('admin.users.import.show') }}" class="btn-secondary">
                    <i class="fas fa-file-import"></i> Import
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" class="search-field" placeholder="Search users..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="class-name-cell">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="role-badge">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-group">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="act-btn btn-blue" title="Edit"><i class="fas fa-edit"></i></a>
                                @if($user->id !== auth()->id() && $user->id !== 1)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn btn-red" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Spacing -->
        <div style="margin-top: 20px; color: #94a3b8;">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection