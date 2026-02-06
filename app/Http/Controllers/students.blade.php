@extends('layouts.app')

@section('title', 'Students - ' . $classSection->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Students in {{ $classSection->name }}</h3>
                <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                    Academic Session: {{ $classSection->academicSession->name ?? 'N/A' }}
                </p>
            </div>
            <a href="{{ url('/classes') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Classes
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email / ID</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classSection->students as $student)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #111827;">{{ $student->name }}</div>
                        </td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 99px; font-size: 12px; font-weight: 600;">Active</span>
                        </td>
                        <td>
                            <a href="{{ action([App\Http\Controllers\ReportCardController::class, 'generateForTeacher'], $student->id) }}" class="btn-secondary" style="font-size: 0.8rem; padding: 4px 10px;" target="_blank">
                                <i class="fas fa-file-alt"></i> Report Card
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 30px;">No students enrolled in this class yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection