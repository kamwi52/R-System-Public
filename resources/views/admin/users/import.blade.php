@extends('layouts.app')
@section('title', 'Import Users')
@section('content')
<div class="content-container">
    <div class="management-card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header-actions">
            <h2 class="management-title">Bulk Import Users</h2>
            <div class="header-btns">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        
        <div class="content-body">
            <p style="margin-bottom: 20px; color: #94a3b8;">
                Upload a CSV or Excel file to import users. The file should have columns: <strong>name, email, password, role</strong>.
            </p>
            
            @if(session('import_errors'))
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.import.handle') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">Select File</label>
                    <input type="file" name="file" class="form-control" required>
                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancel</a>
                <div class="form-actions" style="text-align: right;">
                    <button type="submit" class="btn-primary">Import Users</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection