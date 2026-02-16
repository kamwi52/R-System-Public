@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; font-size: 2rem; font-weight: 700; margin-bottom: 10px;">Linda Secondary School Management System</h1>
        <p style="color: #94a3b8; font-size: 1.1rem;">Welcome back, {{ Auth::user()->name }}!</p>
    </div>

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px;">
        @if(Auth::user()->role === 'admin')
            <div class="lssms-card">
                <div class="icon-wrapper icon-blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Users</h3>
                    <p class="number">{{ $counts['users'] ?? \App\Models\User::count() }}</p>
                </div>
            </div>
            <div class="lssms-card">
                <div class="icon-wrapper icon-green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-content">
                    <h3>Students</h3>
                    <p class="number">{{ $counts['students'] ?? \App\Models\User::where('role', 'student')->count() }}</p>
                </div>
            </div>
            <div class="lssms-card">
                <div class="icon-wrapper icon-purple">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-content">
                    <h3>Teachers</h3>
                    <p class="number">{{ $counts['teachers'] ?? \App\Models\User::where('role', 'teacher')->count() }}</p>
                </div>
            </div>
            <div class="lssms-card">
                <div class="icon-wrapper icon-orange">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="stat-content">
                    <h3>Classes</h3>
                    <p class="number">{{ $counts['classes'] ?? \App\Models\ClassSection::count() }}</p>
                </div>
            </div>
        @else
            <div class="lssms-card">
                <div class="icon-wrapper icon-blue">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-content">
                    <h3>Role</h3>
                    <p class="number" style="font-size: 1.2rem; text-transform: capitalize;">{{ Auth::user()->role }}</p>
                </div>
            </div>
            
            <div class="lssms-card">
                <div class="icon-wrapper icon-orange">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="stat-content">
                    <h3>Notifications</h3>
                    <p class="number">{{ Auth::user()->unreadNotifications->count() }}</p>
                </div>
            </div>
        @endif
    </div>
@endsection