<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Billing System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
        }
        .content {
            flex: 1;
            padding: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h4 class="text-center"><i class="bi bi-cup-hot-fill text-danger"></i> Cafe Billing</h4>
        <hr>
        @auth
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('manager') ? 'manager.dashboard' : 'cashier.dashboard')) }}">
                        <i class="bi bi-house-door-fill me-1"></i> Dashboard
                    </a>
                </li>

                <!-- Collapsible Menu: Master Data -->
                @if (auth()->user()->hasAnyRole(['admin', 'manager']))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#masterMenu" role="button" aria-expanded="false" aria-controls="masterMenu">
                        <i class="bi bi-folder-fill me-1"></i> Master Data
                        <i class="bi bi-chevron-down float-end"></i>
                    </a>
                    <div class="collapse ps-3" id="masterMenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('categories.index') }}">
                                    <i class="bi bi-tags-fill me-1"></i> Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.index') }}">
                                    <i class="bi bi-box-seam me-1"></i> Products
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-card-list"></i> View Orders
                    </a>
                </li>
                @endif

                <!-- Admin Only -->
                @if (auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people-fill me-1"></i> User Management
                    </a>
                </li>
                @endif

                <!-- Cashier: Order Processing -->
                @if (auth()->user()->hasRole('cashier'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.create') }}">
                        <i class="bi bi-cart-fill me-1"></i> Create Order
                    </a>
                </li>
                @endif

                <!-- Logout -->
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        @else
            <a class="btn btn-primary w-100" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('fade');
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }, 1000);
            }
        });
    </script>
</body>
</html>