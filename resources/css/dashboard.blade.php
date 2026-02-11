@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>Here's a quick overview of your system.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon-wrapper icon-blue"><i class="fas fa-users"></i></div>
            <div class="stat-content">
                <h3>Total Users</h3>
                <span class="number">120</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-wrapper icon-green"><i class="fas fa-chart-bar"></i></div>
            <div class="stat-content">
                <h3>Total Sales</h3>
                <span class="number">$25,000</span>
            </div>
        </div>
    </div>

    <!-- Add more stat cards as needed -->
@endsection