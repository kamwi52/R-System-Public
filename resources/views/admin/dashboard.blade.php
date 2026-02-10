@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="dashboard-welcome">
        <h1>Admin Dashboard</h1>
        <p>System Overview and Management</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon-wrapper icon-blue">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3>Students</h3>
                <p class="number">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper icon-green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <h3>Teachers</h3>
                <p class="number">{{ $totalTeachers }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper icon-purple">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="stat-content">
                <h3>Classes</h3>
                <p class="number">{{ $totalClasses }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper icon-orange">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3>Subjects</h3>
                <p class="number">{{ $totalSubjects }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Quick Actions</h3>
        </div>
        <div class="content-body">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('admin.users.index') }}" class="btn-primary"><i class="fas fa-users"></i> Manage Users</a>
                <a href="{{ route('admin.classes.index') }}" class="btn-primary"><i class="fas fa-chalkboard"></i> Manage Classes</a>
                <a href="{{ route('admin.subjects.index') }}" class="btn-primary"><i class="fas fa-book"></i> Manage Subjects</a>
            </div>
        </div>
    </div>
@endsection