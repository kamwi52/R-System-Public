@extends('layouts.app')
@section('title', 'User Management')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>All Users</h3>
        <div style="display: flex; gap: 10px;">
            <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 5px;">
                <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}" style="width: 200px;">
                <button type="submit" class="btn-secondary"><i class="fas fa-search"></i></button>
            </form>
            <a href="{{ route('admin.users.import.show') }}" class="btn-secondary">
                <i class="fas fa-file-import"></i> Import
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $user->name }}</div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span style="text-transform: capitalize; background: #f3f4f6; padding: 2px 8px; border-radius: 99px; font-size: 12px; font-weight: 600;">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id !== auth()->id() && $user->id !== 1)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Delete" style="background:none;border:none;cursor:pointer;color:#ef4444;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 30px;">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px;">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection