@extends('layouts.app')

@section('title', 'Enroll Student')

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
        font-size: 0.9rem;
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
    }
    .btn-lssms-primary:hover {
        background-color: #7c3aed;
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.4);
        transform: translateY(-1px);
    }
    .btn-lssms-primary:disabled {
        background-color: #475569;
        cursor: not-allowed;
        box-shadow: none;
    }
    .btn-lssms-secondary {
        background-color: transparent;
        border: 1px solid #475569;
        color: #94a3b8;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-lssms-secondary:hover {
        background-color: #334155;
        color: #f8fafc;
    }
</style>

<div style="max-width: 600px; margin: 0 auto;">
    <div class="lssms-card">
        <div class="card-header" style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <h3 style="margin: 0; color: #f8fafc; font-size: 1.25rem;">Enroll Student into {{ $classSection->name }}</h3>
        </div>
        
        <div class="content-body" style="padding: 24px;">
            <form action="{{ route('classes.enroll.store', $classSection->id) }}" method="POST">
                @csrf
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="lssms-label">Select Student</label>
                    <select name="student_id" class="lssms-input" required>
                        <option value="">-- Select a student --</option>
                        @forelse($availableStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @empty
                            <option value="" disabled>No unassigned students found</option>
                        @endforelse
                    </select>
                    <p style="margin-top: 8px; font-size: 0.85rem; color: #64748b;">
                        Only students not currently assigned to a class are listed here.
                    </p>
                </div>

                <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 12px;">
                    <a href="{{ route('classes.students', $classSection->id) }}" class="btn-lssms-secondary">Cancel</a>
                    <button type="submit" class="btn-lssms-primary" {{ $availableStudents->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-user-plus"></i> Enroll Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection