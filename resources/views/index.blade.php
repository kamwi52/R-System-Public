@extends('layouts.app')

@section('title', 'Class Management')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>All Classes</h3>
            <a href="{{ url('/classes/create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Add New Class
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Academic Session</th>
                        <th>Students</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes ?? [] as $class)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #111827;">{{ $class->name }}</div>
                        </td>
                        <td>{{ $class->academicSession->name ?? 'N/A' }}</td>
                        <td>
                            <span style="background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 99px; font-size: 12px; font-weight: 600;">
                                {{ $class->students_count ?? 0 }} Students
                            </span>
                        </td>
                        <td>
                            <a href="{{ action([App\Http\Controllers\ReportCardController::class, 'generateForClass'], $class->id) }}" class="action-btn" title="Generate Reports" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="#" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 30px;">No classes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
