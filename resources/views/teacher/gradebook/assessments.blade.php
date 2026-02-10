@extends('layouts.app')

@section('title', 'Gradebook - ' . $subject->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <h3>{{ $subject->name }} <span style="color: #9ca3af; font-weight: normal;">/ {{ $classSection->name }}</span></h3>
                <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Select an assessment to enter marks.</p>
            </div>
            <a href="{{ route('teacher.dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Assessment Title</th>
                        <th>Type</th>
                        <th>Max Score</th>
                        <th>Grading Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assessments as $assessment)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #111827;">{{ $assessment->title ?? $assessment->name }}</div>
                        </td>
                        <td>{{ $assessment->type ?? 'General' }}</td>
                        <td>{{ $assessment->max_score ?? 100 }}</td>
                        <td>
                            @php
                                $studentCount = $classSection->students->count();
                                $gradedCount = $assessment->graded_count ?? 0;
                                $percentage = $studentCount > 0 ? ($gradedCount / $studentCount) * 100 : 0;
                            @endphp
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; height: 6px; background: #e5e7eb; border-radius: 3px; width: 100px;">
                                    <div style="height: 100%; background: #4f46e5; border-radius: 3px; width: {{ $percentage }}%;"></div>
                                </div>
                                <span style="font-size: 0.8rem; color: #6b7280;">{{ $gradedCount }}/{{ $studentCount }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('teacher.gradebook.results', $assessment->id) }}" class="btn-primary" style="padding: 6px 12px; font-size: 0.85rem;">
                                <i class="fas fa-pen"></i> Enter Marks
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #6b7280; padding: 30px;">
                            No assessments found for this subject. 
                            <br><small>Please ask an administrator to create assessments.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection