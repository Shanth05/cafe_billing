@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4 position-relative">

        <!-- Back to Home Button -->
        <div class="mb-3 text-center">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm w-100">
                &larr; Back to Home
            </a>
        </div>

        <h3 class="mb-4 text-center">Cafe Billing - Access</h3>

        {{-- Toast Flash Message --}}
        @if(session('status'))
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
                <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="statusToast">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('status') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3 justify-content-center" id="authTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tab === 'login' ? 'active' : '' }}" id="login-tab" data-bs-toggle="tab"
                    data-bs-target="#login" type="button" role="tab" aria-controls="login"
                    aria-selected="{{ $tab === 'login' ? 'true' : 'false' }}">
                    Login
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $tab === 'register' ? 'active' : '' }}" id="register-tab" data-bs-toggle="tab"
                    data-bs-target="#register" type="button" role="tab" aria-controls="register"
                    aria-selected="{{ $tab === 'register' ? 'true' : 'false' }}">
                    Register
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="authTabsContent">
            <!-- Login Tab -->
            <div class="tab-pane fade {{ $tab === 'login' ? 'show active' : '' }}" id="login" role="tabpanel"
                aria-labelledby="login-tab">
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label fw-semibold">Email</label>
                        <input type="email" id="loginEmail" name="email" class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label fw-semibold">Password</label>
                        <input type="password" id="loginPassword" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="mb-3 text-center">
                        <p>Or login with:</p>
                        <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-outline-danger btn-sm me-1" title="Login with Google">
                            <i class="bi bi-google"></i> Google
                        </a>
                        <a href="{{ route('social.redirect', ['provider' => 'github']) }}" class="btn btn-outline-dark btn-sm me-1" title="Login with GitHub">
                            <i class="bi bi-github"></i> GitHub
                        </a>
                        <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-outline-primary btn-sm" title="Login with Facebook">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                    </div>
                </form>
            </div>

            <!-- Register Tab -->
            <div class="tab-pane fade {{ $tab === 'register' ? 'show active' : '' }}" id="register" role="tabpanel"
                aria-labelledby="register-tab">
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="registerName" class="form-label fw-semibold">Name</label>
                        <input type="text" id="registerName" name="name" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label fw-semibold">Email</label>
                        <input type="email" id="registerEmail" name="email" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label fw-semibold">Password</label>
                        <input type="password" id="registerPassword" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="registerPasswordConfirm" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" id="registerPasswordConfirm" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>

                    <!-- Social Register Buttons -->
                    <div class="mb-3 text-center">
                        <p>Or register with:</p>
                        <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-outline-danger btn-sm me-1" title="Register with Google">
                            <i class="bi bi-google"></i> Google
                        </a>
                        <a href="{{ route('social.redirect', ['provider' => 'github']) }}" class="btn btn-outline-dark btn-sm me-1" title="Register with GitHub">
                            <i class="bi bi-github"></i> GitHub
                        </a>
                        <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-outline-primary btn-sm" title="Register with Facebook">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Toast auto-hide script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('statusToast');
        if (toastEl) {
            const bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
            bsToast.show();
        }
    });
</script>
@endsection
