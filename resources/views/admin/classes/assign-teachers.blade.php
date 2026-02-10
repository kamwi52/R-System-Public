@extends('layouts.app')
@section('title', 'Assign Teachers')
@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Assign Teachers</h3>
                <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                    Class: <strong>{{ $classSection->name }}</strong> ({{ $classSection->academicSession->name }})
                </p>
            </div>
            <a href="{{ route('admin.classes.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="content-body">
            @if($classSection->subjects->isEmpty())
                <div style="text-align: center; padding: 30px; color: #6b7280;">
                    <p>No subjects assigned to this class yet.</p>
                    <a href="{{ route('admin.classes.edit', $classSection->id) }}" class="btn-primary" style="margin-top: 10px;">
                        Edit Class to Add Subjects
                    </a>
                </div>
            @else
                <form action="{{ route('admin.classes.teachers.store', $classSection->id) }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Subject</th>
                                    <th style="width: 60%;">Teacher</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classSection->subjects as $subject)
                                <tr>
                                    <td style="vertical-align: middle; font-weight: 500;">{{ $subject->name }}</td>
                                    <td>
                                        <select name="assignments[{{ $subject->id }}]" class="form-control">
                                            <option value="">-- Select Teacher --</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ $subject->pivot->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-actions" style="margin-top: 20px;">
                        <button type="submit" class="btn-primary">Save Assignments</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection