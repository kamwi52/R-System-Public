@extends('layouts.app')

@section('title', 'Classes')

@section('content')
<div class="content-container">
    <div class="management-card">
        <div class="card-header-actions">
            <h2 class="management-title">Class List</h2>
        </div>

        <div class="search-section">
            <form action="{{ url('/classes') }}" method="GET" class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search classes..." class="search-field" value="{{ request('search') }}">
            </form>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>CLASS NAME</th>
                        <th>STUDENTS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->students_count ?? 0 }} students</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" style="text-align: center; padding: 30px; color: #e2e8f0;">No classes found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection