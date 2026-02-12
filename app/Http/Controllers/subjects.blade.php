@extends('layouts.app')

@section('title', 'Subjects - ' . $classSection->name)

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
    .lssms-input {
        background-color: #0f172a;
        border: 1px solid #334155;
        color: #f8fafc;
        border-radius: 8px;
        padding: 10px 12px;
        width: 100%;
    }
    .lssms-input:focus {
        border-color: #8b5cf6;
        outline: none;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
    }
    .lssms-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.85rem;
    }
    .btn-lssms-primary {
        background-color: #8b5cf6;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-lssms-primary:hover {
        background-color: #7c3aed;
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.4);
        transform: translateY(-1px);
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
</style>

    <div class="lssms-card">
        <div class="card-header" style="padding: 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <div>
                <h3 style="margin: 0; color: #f8fafc; font-size: 1.25rem;">Manage Subjects for {{ $classSection->name }}</h3>
            </div>
            <a href="{{ url('/classes') }}" class="btn-lssms-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        
        <div class="content-body" style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); background-color: rgba(15, 23, 42, 0.3);">
            <form action="{{ route('classes.subjects.store', $classSection->id) }}" method="POST" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                @csrf
                <div style="flex: 1; min-width: 200px;">
                    <label class="lssms-label">Subject</label>
                    <select name="subject_id" class="lssms-input" required>
                        <option value="">Select Subject...</option>
                        @foreach($allSubjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="lssms-label">Assign Teacher</label>
                    <select name="teacher_id" class="lssms-input" required>
                        <option value="">Select Teacher...</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-lssms-primary" style="margin-bottom: 1px;">
                    <i class="fas fa-plus"></i> Assign
                </button>
            </form>
        </div>

        <div class="table-responsive" style="overflow-x: auto;">
            <table class="lssms-table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Code</th>
                        <th>Assigned Teacher</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classSection->subjects as $subject)
                    <tr>
                        <td>
                            <div class="text-primary-highlight">{{ $subject->name }}</div>
                        </td>
                        <td>{{ $subject->code ?? '-' }}</td>
                        <td>
                            @php
                                $assignedTeacher = $teachers->firstWhere('id', $subject->pivot->teacher_id);
                            @endphp
                            <span style="color: #e2e8f0;">{{ $assignedTeacher->name ?? 'Unknown' }}</span>
                        </td>
                        <td style="text-align: right;">
                            <form action="{{ route('classes.subjects.remove', [$classSection->id, $subject->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Remove this subject from the class?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Remove Subject" style="background: rgba(248, 113, 113, 0.1); border: none; cursor: pointer; color: #f87171; width: 32px; height: 32px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">No subjects assigned to this class yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection