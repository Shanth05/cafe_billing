<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cafe Billing System</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .avatar-circle {
            width: 32px;
            height: 32px;
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            font-weight: bold;
            font-size: 16px;
            user-select: none;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand text-success fw-bold" href="{{ url('/') }}">Cafe Billing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Flash Messages -->
<div class="container mt-3">
  @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
</div>

<!-- Hero Section -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="display-4 fw-bold text-success">Welcome to Cafe Billing System</h1>
        <p class="lead text-muted">
          Simplify your cafe's order and billing process with our intuitive and powerful system.
          Track orders, manage bills, and serve customers efficiently.
        </p>

        @guest
          <a href="{{ route('login') }}" class="btn btn-success btn-lg me-2">Get Started</a>
          <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">Register Now</a>
        @else
          @php $user = Auth::user(); @endphp
          @if($user->hasRole('admin'))
            <a href="{{ route('admin.dashboard') }}" class="btn btn-success btn-lg me-2">Go to Admin Dashboard</a>
          @elseif($user->hasRole('manager'))
            <a href="{{ route('manager.dashboard') }}" class="btn btn-success btn-lg me-2">Go to Manager Dashboard</a>
          @elseif($user->hasRole('cashier'))
            <a href="{{ route('cashier.dashboard') }}" class="btn btn-success btn-lg me-2">Go to Cashier Dashboard</a>
          @else
            <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg me-2">Go to Dashboard</a>
          @endif
        @endguest

      </div>
      <div class="col-md-6 text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" alt="Cafe Billing" class="img-fluid" style="max-height: 350px;">
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-light py-4 mt-auto">
  <div class="container text-center text-muted">
    &copy; {{ date('Y') }} Cafe Billing System. All rights reserved.
  </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
