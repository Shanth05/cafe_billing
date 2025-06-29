@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <h3 class="mb-4 text-center">Cafe Billing - Access</h3>

        @if (session('status'))
            <div id="statusAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('statusAlert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 4000);
            </script>
        @endif

        <ul class="nav nav-tabs mb-3 justify-content-center" id="authTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="false">
                    Login
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">
                    Register
                </button>
            </li>
        </ul>

        <div class="tab-content" id="authTabsContent">
            <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <input type="hidden" name="fakeusernameremembered">
                    <input type="hidden" name="fakepasswordremembered">

                    <div class="mb-3">
                        <label for="loginEmail" class="form-label fw-semibold">Email</label>
                        <input type="text" id="loginEmail" name="email" inputmode="email" autocomplete="new-email"
                            class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="loginPassword" class="form-label fw-semibold">Password</label>
                        <input type="password" id="loginPassword" name="password" autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf

                    <input type="hidden" name="fakeusernameremembered">
                    <input type="hidden" name="fakepasswordremembered">

                    <div class="mb-3">
                        <label for="registerName" class="form-label fw-semibold">Name</label>
                        <input type="text" id="registerName" name="name" autocomplete="new-name"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="registerEmail" class="form-label fw-semibold">Email</label>
                        <input type="text" id="registerEmail" name="email" inputmode="email" autocomplete="new-email"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="registerPassword" class="form-label fw-semibold">Password</label>
                        <input type="password" id="registerPassword" name="password" autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="registerPasswordConfirm" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" id="registerPasswordConfirm" name="password_confirmation" autocomplete="new-password"
                            class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab') || 'login';

                const triggerEl = document.querySelector(`#${tab}-tab`);
                if (triggerEl) {
                    const tabTrigger = new bootstrap.Tab(triggerEl);
                    tabTrigger.show();
                }
            });
        </script>
    </div>
</div>
@endsection
