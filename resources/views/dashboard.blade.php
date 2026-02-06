@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome">
        <h1>Welcome back, {{ Auth::user()->name }}!</h1>
        <p>Here is an overview of your academic activity.</p>
    </div>

    <div class="stats-grid">
        <!-- Card 1 -->
        <div class="stat-card">
            <div class="icon-wrapper icon-blue">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3>Role</h3>
                <p class="number" style="font-size: 1.2rem; text-transform: capitalize;">{{ Auth::user()->role }}</p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="stat-card">
            <div class="icon-wrapper icon-green">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>Academic Session</h3>
                <p class="number" style="font-size: 1.2rem;">2023-2024</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="stat-card">
            <div class="icon-wrapper icon-purple">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-content">
                <h3>Active Subjects</h3>
                <p class="number">
                    @if(Auth::user()->role === 'student' && Auth::user()->classSection)
                        {{ Auth::user()->classSection->subjects->count() }}
                    @else
                        <span>-</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="stat-card">
            <div class="icon-wrapper icon-orange">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-content">
                <h3>Notifications</h3>
                <p class="number">3</p>
            </div>
        </div>
    </div>
@endsection