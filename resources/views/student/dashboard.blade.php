@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    <div class="dashboard-welcome">
        <h1>Welcome, {{ $student->name }}!</h1>
        <p>Academic Session: {{ $classSection->academicSession->name ?? 'N/A' }}</p>
    </div>

    @if(!$classSection)
        <div class="card" style="padding: 40px; text-align: center;">
            <div style="color: #9ca3af; font-size: 4rem; margin-bottom: 20px;">
                <i class="fas fa-user-clock"></i>
            </div>
            <h3>Not Enrolled</h3>
            <p style="color: #6b7280;">You are not currently enrolled in any class. Please contact the administrator.</p>
        </div>
    @else
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon-wrapper icon-blue">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="stat-content">
                    <h3>My Class</h3>
                    <p class="number" style="font-size: 1.2rem;">{{ $classSection->name }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon-wrapper icon-green">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3>Subjects</h3>
                    <p class="number">{{ $classSection->subjects->count() }}</p>
                </div>
            </div>

            <div class="stat-card" style="cursor: pointer;" onclick="window.open('{{ route('student.my.report') }}', '_blank')">
                <div class="icon-wrapper icon-purple">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>Report Card</h3>
                    <p class="number" style="font-size: 1rem; color: var(--primary);">Download PDF</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>My Subjects</h3>
            </div>
            <div class="content-body">
                <ul style="list-style: none; padding: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                    @foreach($classSection->subjects as $subject)
                        <li style="background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <div style="font-weight: 600; color: #111827;">{{ $subject->name }}</div>
                            <div style="font-size: 0.85rem; color: #6b7280;">{{ $subject->code ?? '' }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection