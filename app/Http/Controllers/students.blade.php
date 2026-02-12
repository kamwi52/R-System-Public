@extends('layouts.app')

@section('title', 'Students - ' . $classSection->name)

@section('content')
<style>
    /* LSSMS Styles */
    .lssms-card {
        background-color: #1e293b;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        color: #f8fafc;
    }
    .lssms-table {
        width: 100%;
        border-collapse: collapse;
    }
    .lssms-table thead th {
        background-color: rgba(30, 41, 59, 0.5);
        color: #64748b;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 16px 24px;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .lssms-table tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.02);
        transition: background-color 0.2s;
    }
    .lssms-table tbody tr:nth-child(odd) {
        background-color: rgba(255, 255, 255, 0.02);
    }
    .lssms-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.04);
    }
    .lssms-table td {
        padding: 16px 24px;
        color: #94a3b8;
        font-size: 0.95rem;
    }
    .text-primary-highlight {
        color: #f8fafc;
        font-weight: 600;
    }
    .btn-lssms-secondary {
        background-color: transparent;
        border: 1px solid #475569;
        color: #94a3b8;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-lssms-secondary:hover {
        background-color: #334155;
        color: #f8fafc;
    }
    .status-badge {
        background: rgba(16, 185, 129, 0.1);
        color: #34d399;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .action-icon-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
        margin-right: 4px;
        background-color: rgba(56, 189, 248, 0.1); 
        color: #38bdf8;
    }
    .action-icon-btn:hover {
        background-color: rgba(56, 189, 248, 0.2);
    }
</style>

    <div class="lssms-card">
        <div class="card-header" style="padding: 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <div>
                <h3 style="margin: 0; color: #f8fafc; font-size: 1.25rem;">Students in {{ $classSection->name }}</h3>
                <p style="margin: 4px 0 0; color: #64748b; font-size: 0.875rem;">
                    Academic Session: {{ $classSection->academicSession->name ?? 'N/A' }}
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                 <a href="{{ route('classes.enroll', $classSection->id) }}" class="btn-lssms-secondary" style="border-color: #8b5cf6; color: #a78bfa;">
                    <i class="fas fa-user-plus"></i> Enroll Student
                </a>
                <a href="{{ url('/classes') }}" class="btn-lssms-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="lssms-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email / ID</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classSection->students as $student)
                    <tr>
                        <td>
                            <div class="text-primary-highlight">{{ $student->name }}</div>
                        </td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <span class="status-badge">Active</span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ action([App\Http\Controllers\ReportCardController::class, 'generateForTeacher'], $student->id) }}" class="action-icon-btn" title="Report Card" target="_blank">
                                <i class="fas fa-file-alt"></i>
                            </a>
                             <form action="{{ route('classes.students.remove', [$classSection->id, $student->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Remove this student from the class?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon-btn" title="Remove Student" style="background-color: rgba(248, 113, 113, 0.1); color: #f87171; border: none; cursor: pointer;">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">No students enrolled in this class yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection