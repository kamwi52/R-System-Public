@extends('layouts.app')
@section('title', 'User Management')
@section('content')
<div class="content-container">
    <div class="management-card">
        <!-- Header Section -->
        <div class="card-header-actions">
            <h2 class="management-title">User Management</h2>
            <div class="action-buttons">
                <a href="{{ route('admin.users.import.show') }}" class="btn-import">
                    <i class="fas fa-file-import"></i> Import Users
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('admin.users.index') }}" method="GET" class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search by name, email or role..." class="search-field" value="{{ request('search') }}">
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge" style="text-transform: capitalize; background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; color: #e2e8f0;">{{ $user->role }}</span>
                        </td>
                        <td class="text-center actions-cell">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="edit-link"><i class="fas fa-edit"></i></a>
                            @if($user->id !== auth()->id() && $user->id !== 1)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete-link"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #e2e8f0;">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-container">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection