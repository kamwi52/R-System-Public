@extends('layouts.app')
@section('title', 'Result Management')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Student Results</h3>
        <div style="display: flex; gap: 10px;">
             <a href="{{ route('admin.results.import.show') }}" class="btn-secondary">
                <i class="fas fa-file-import"></i> Import Results
            </a>
            <a href="{{ route('admin.results.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Add Result
            </a>
        </div>
    </div>
    {{-- Filter Form --}}
    <div class="content-body" style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
        <form action="{{ route('admin.results.index') }}" method="GET" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label">Filter by Assessment</label>
                <select name="assessment_id" class="form-control">
                    <option value="">All Assessments</option>
                    @foreach($assessments as $assessment)
                        <option value="{{ $assessment->id }}" {{ request('assessment_id') == $assessment->id ? 'selected' : '' }}>
                            {{ $assessment->name }} ({{ $assessment->classSection->name ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label class="form-label">Search Student</label>
                <input type="text" name="student_name" class="form-control" placeholder="Student Name..." value="{{ request('student_name') }}">
            </div>
            <button type="submit" class="btn-primary" style="margin-bottom: 2px;">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Assessment</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $result->student->name ?? 'Unknown' }}</div>
                        <div style="font-size: 0.85rem; color: #6b7280;">{{ $result->student->email ?? '' }}</div>
                    </td>
                    <td>
                        {{ $result->assessment->name ?? 'N/A' }}
                        <div style="font-size: 0.85rem; color: #6b7280;">{{ $result->assessment->classSection->name ?? '' }}</div>
                    </td>
                    <td>
                        <span style="font-weight: bold;">{{ $result->score }}</span> / {{ $result->assessment->max_marks ?? 100 }}
                    </td>
                    <td>
                        <a href="{{ route('admin.results.edit', $result->id) }}" class="action-btn" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.results.destroy', $result->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this result?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" style="background:none;border:none;cursor:pointer;color:#ef4444;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 30px;">No results found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px;">
        {{ $results->withQueryString()->links() }}
    </div>
</div>
@endsection