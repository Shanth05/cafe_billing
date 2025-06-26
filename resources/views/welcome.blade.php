<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cafe Billing System</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Register</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

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
        <a href="{{ route('login') }}" class="btn btn-success btn-lg me-2">Get Started</a>
        <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">Register Now</a>
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
