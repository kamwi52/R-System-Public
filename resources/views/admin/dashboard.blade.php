@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    /* LSSMS Dashboard Styles */
    .lssms-card {
        background-color: #1e293b;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.2s;
    }
    .lssms-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .icon-blue { background: rgba(56, 189, 248, 0.1); color: #38bdf8; }
    .icon-green { background: rgba(52, 211, 153, 0.1); color: #34d399; }
    .icon-purple { background: rgba(139, 92, 246, 0.1); color: #a78bfa; }
    .icon-orange { background: rgba(251, 146, 60, 0.1); color: #fb923c; }
    
    .stat-content h3 {
        color: #94a3b8;
        font-size: 0.875rem;
        font-weight: 500;
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .stat-content .number {
        color: #f8fafc;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
    }
</style>
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; font-size: 2rem; font-weight: 700; margin-bottom: 10px;">Linda Secondary School Management System</h1>
        <p style="color: #94a3b8; font-size: 1.1rem;">Admin Dashboard - System Overview</p>
    </div>

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 30px;">
        <div class="lssms-card">
            <div class="icon-wrapper icon-blue">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3>Students</h3>
                <p class="number">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="lssms-card">
            <div class="icon-wrapper icon-green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <h3>Teachers</h3>
                <p class="number">{{ $totalTeachers }}</p>
            </div>
        </div>
        <div class="lssms-card">
            <div class="icon-wrapper icon-purple">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="stat-content">
                <h3>Classes</h3>
                <p class="number">{{ $totalClasses }}</p>
            </div>
        </div>
        <div class="lssms-card">
            <div class="icon-wrapper icon-orange">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3>Subjects</h3>
                <p class="number">{{ $totalSubjects }}</p>
            </div>
        </div>
    </div>

    <div class="card" style="background-color: #1e293b; border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <h3 style="color: #f8fafc; margin: 0;">Quick Actions</h3>
        </div>
        <div class="content-body" style="padding: 24px;">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('admin.users.index') }}" class="btn-primary" style="background-color: #8b5cf6; color: white; border-radius: 8px; padding: 10px 20px; text-decoration: none; font-weight: 600; border: none; transition: all 0.2s;"><i class="fas fa-users"></i> Manage Users</a>
                <a href="{{ route('admin.classes.index') }}" class="btn-primary" style="background-color: #8b5cf6; color: white; border-radius: 8px; padding: 10px 20px; text-decoration: none; font-weight: 600; border: none; transition: all 0.2s;"><i class="fas fa-chalkboard"></i> Manage Classes</a>
                <a href="{{ route('admin.subjects.index') }}" class="btn-primary" style="background-color: #8b5cf6; color: white; border-radius: 8px; padding: 10px 20px; text-decoration: none; font-weight: 600; border: none; transition: all 0.2s;"><i class="fas fa-book"></i> Manage Subjects</a>
            </div>
        </div>
    </div>
@endsection