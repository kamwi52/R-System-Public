@extends('layouts.app')
@section('title', 'Import Results')
@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Bulk Import Results</h3>
        </div>
        <div class="content-body">
            <p style="margin-bottom: 20px; color: #6b7280;">
                Upload a CSV file to import results. <br>
                <strong>Required Columns:</strong> assessment_id, student_email, score
            </p>
            
            @if(session('import_errors'))
                <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong>Import Errors:</strong>
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.results.import.handle') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Select CSV File</label>
                    <input type="file" name="file" class="form-control" accept=".csv" required>
                </div>
                <div class="form-actions">
                    <a href="{{ route('admin.results.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Import Results</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection