@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="dashboard-welcome">
        <h1>Hello, {{ Auth::user()->name }}</h1>
        <p>Select a subject below to manage assessments and grades.</p>
    </div>

    @if($assignedClasses->isEmpty())
        <div class="card" style="padding: 40px; text-align: center;">
            <div style="color: #9ca3af; font-size: 4rem; margin-bottom: 20px;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3>No Subjects Assigned</h3>
            <p style="color: #6b7280;">You have not been assigned to any classes yet. Please contact the administrator.</p>
        </div>
    @else
        <div class="stats-grid">
            @foreach($assignedClasses as $class)
                @foreach($class->subjects as $subject)
                    <div class="stat-card" style="display: block; position: relative; overflow: hidden;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                            <div class="icon-wrapper icon-blue" style="margin: 0;">
                                <i class="fas fa-book"></i>
                            </div>
                            <span style="background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 99px; font-size: 11px; font-weight: 600;">
                                {{ $class->academicSession->name ?? 'Session N/A' }}
                            </span>
                        </div>
                        
                        <h3 style="font-size: 1.1rem; color: #111827; margin-bottom: 5px; font-weight: 700;">
                            {{ $subject->name }}
                        </h3>
                        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 20px;">
                            {{ $class->name }} &bull; {{ $class->students->count() }} Students
                        </p>

                        <div style="border-top: 1px solid #f3f4f6; padding-top: 15px; display: flex; gap: 10px;">
                            <a href="{{ route('teacher.gradebook.assessments', [$class->id, $subject->id]) }}" class="btn-primary" style="flex: 1; justify-content: center; font-size: 0.85rem;">
                                <i class="fas fa-edit"></i> Gradebook
                            </a>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @endif

    <div style="margin-top: 40px;">
        <h3 style="margin-bottom: 20px; color: #374151;">Quick Stats</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <h3>Total Classes</h3>
                    <p class="number">{{ $assignedClasses->count() }}</p>
                </div>
            </div>
            <!-- Additional stats can be added here -->
        </div>
    </div>
@endsection