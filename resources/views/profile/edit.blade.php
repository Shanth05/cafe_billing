@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Edit Profile</h2>

    {{-- Success Message --}}
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="profileUpdateAlert">
            Profile updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        {{-- Name --}}
        <div class="mb-4">
            <label for="name" class="form-label fw-semibold">Name</label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email address</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">New Password <small class="text-muted">(leave blank to keep current)</small></label>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                name="password"
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Confirmation --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
            <input
                type="password"
                class="form-control"
                id="password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
            >
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
        </div>
    </form>

    <hr class="my-5">

    {{-- Delete Account --}}
    <h4 class="mb-3 text-danger">Delete Account</h4>
    <p class="mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-4">
            <label for="current_password" class="form-label fw-semibold">Current Password</label>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="current_password"
                name="password"
                required
                autocomplete="current-password"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-danger btn-lg">Delete Account</button>
        </div>
    </form>
</div>

{{-- Auto-hide alert after 3 seconds --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('profileUpdateAlert');
        if (alert) {
            setTimeout(() => {
                // Bootstrap 5 fade out
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        }
    });
</script>
@endsection
