@extends('layouts.app')
@section('title', 'Academic Sessions')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Academic Sessions</h3>
        <a href="{{ route('admin.academic-sessions.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add Session
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($academicSessions as $session)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $session->name }}</div>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($session->start_date)->format('M Y') }} - 
                        {{ \Carbon\Carbon::parse($session->end_date)->format('M Y') }}
                    </td>
                    <td>
                        @if($session->is_current)
                            <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 99px; font-size: 12px; font-weight: 600;">Current Session</span>
                        @else
                            <span style="background: #f3f4f6; color: #6b7280; padding: 2px 8px; border-radius: 99px; font-size: 12px; font-weight: 600;">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.academic-sessions.edit', $session->id) }}" class="action-btn" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.academic-sessions.destroy', $session->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this session? Warning: This may affect linked classes.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" style="background:none;border:none;cursor:pointer;color:#ef4444;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 30px;">No academic sessions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px;">
        {{ $academicSessions->links() }}
    </div>
</div>
@endsection