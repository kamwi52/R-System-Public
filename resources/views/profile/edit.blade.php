@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <!-- Profile Information -->
    <div class="card">
        <div class="card-header">
            <h3>Profile Information</h3>
        </div>
        <div class="content-body">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label class="form-label">Profile Photo</label>
                    <div style="display: flex; align-items: center; gap: 20px;">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Profile" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 64px; height: 64px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 24px;">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control" style="width: auto;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="card">
        <div class="card-header">
            <h3>Update Password</h3>
        </div>
        <div class="content-body">
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection