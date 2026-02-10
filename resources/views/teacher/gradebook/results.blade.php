@extends('layouts.app')

@section('title', 'Enter Marks - ' . $assessment->title)

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Enter Marks: {{ $assessment->title ?? $assessment->name }}</h3>
                <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                    {{ $classSection->name }} &bull; Max Score: {{ $assessment->max_score ?? 100 }}
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('teacher.gradebook.summary.print', $assessment->id) }}" class="btn-secondary" target="_blank">
                    <i class="fas fa-print"></i> Print Summary
                </a>
                <a href="{{ route('teacher.gradebook.assessments', [$classSection->id, $assessment->subject_id]) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        
        <div class="content-body">
            @if(session('success'))
                <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.gradebook.results.store', $assessment->id) }}">
                @csrf
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60%;">Student Name</th>
                                <th style="width: 40%;">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #111827;">{{ $student->name }}</div>
                                        <div style="font-size: 0.85rem; color: #6b7280;">{{ $student->email }}</div>
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}]" 
                                               value="{{ old('scores.' . $student->id, $results[$student->id]->score ?? '') }}"
                                               class="form-control"
                                               style="width: 150px;"
                                               step="0.01"
                                               min="0"
                                               max="{{ $assessment->max_score ?? 100 }}"
                                               placeholder="0 - {{ $assessment->max_score ?? 100 }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="text-align: center; padding: 30px; color: #6b7280;">
                                        No students found in this class.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="form-actions" style="margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Grades
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection