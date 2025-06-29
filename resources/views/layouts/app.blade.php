<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cafe Billing System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #wrapper {
            display: flex;
            flex: 1;
            min-height: 100vh;
            overflow: hidden;
        }
        /* Sidebar */
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        #sidebar.collapsed {
            margin-left: -250px;
        }
        #sidebar .nav-link {
            color: #333;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: #28a745;
            color: white;
        }
        #sidebar .nav .nav {
            padding-left: 1rem;
        }
        #sidebar .logout-item {
            margin-top: auto;
            padding: 1rem;
        }

        /* Content */
        #content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: #fff;
        }

        /* Topbar */
        #topbar {
            height: 56px;
            background-color: #28a745;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            justify-content: space-between;
            flex-shrink: 0;
        }
        #topbar .btn-toggle-sidebar {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        #topbar .brand {
            font-weight: 700;
            font-size: 1.25rem;
            user-select: none;
        }
        #topbar .user-dropdown {
            position: relative;
        }
        #topbar .user-dropdown img,
        #topbar .user-dropdown .avatar-initials {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #155724;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            user-select: none;
        }
        #topbar .dropdown-menu {
            right: 0;
            left: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                top: 56px;
                left: 0;
                height: calc(100vh - 56px);
                z-index: 1030;
                margin-left: -250px;
            }
            #sidebar.collapsed {
                margin-left: 0;
            }
            #content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <nav id="topbar" class="d-flex">
        <button class="btn-toggle-sidebar" aria-label="Toggle Sidebar" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="brand">Cafe Billing</div>

        @auth
        <div class="dropdown user-dropdown">
            <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="User Avatar" />
                @else
                    <div class="avatar-initials">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <span class="ms-2">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
    </nav>

    <div id="wrapper">
        <nav id="sidebar" class="collapsed">
            <h4 class="text-center mt-3"><i class="bi bi-cup-hot-fill text-danger"></i> Cafe Billing</h4>
            <hr />

            @auth
            <ul class="nav flex-column px-2">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route(auth()->user()->hasRole('admin') ? 'admin.dashboard' : (auth()->user()->hasRole('manager') ? 'manager.dashboard' : 'cashier.dashboard')) }}">
                        <i class="bi bi-house-door-fill me-1"></i> Dashboard
                    </a>
                </li>

                @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#manageItemsCollapse" role="button" aria-expanded="{{ request()->routeIs(['categories.*', 'products.*']) ? 'true' : 'false' }}" aria-controls="manageItemsCollapse">
                        <span class="fw-bold">Manage Items</span>
                        <i class="bi bi-chevron-down toggle-icon"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs(['categories.*', 'products.*']) ? 'show' : '' }}" id="manageItemsCollapse">
                        <ul class="nav flex-column ms-3 mb-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="bi bi-tags-fill me-1"></i> Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="bi bi-box-fill me-1"></i> Products
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-card-list me-1"></i> View Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people-fill me-1"></i> User Management
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#reportsCollapse" role="button" aria-expanded="{{ request()->routeIs(['reports.daily', 'reports.monthly']) ? 'true' : 'false' }}" aria-controls="reportsCollapse">
                        <span class="fw-bold">Reports</span>
                        <i class="bi bi-chevron-down toggle-icon"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs(['reports.daily', 'reports.monthly']) ? 'show' : '' }}" id="reportsCollapse">
                        <ul class="nav flex-column ms-3 mb-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('reports.daily') ? 'active' : '' }}" href="{{ route('reports.daily') }}">
                                    <i class="bi bi-calendar-day me-1"></i> Daily Report
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('reports.monthly') ? 'active' : '' }}" href="{{ route('reports.monthly') }}">
                                    <i class="bi bi-calendar-month me-1"></i> Monthly Report
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @if(auth()->user()->hasRole('cashier'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cashier.pos') ? 'active' : '' }}" href="{{ route('cashier.pos') }}">
                        <i class="bi bi-cart-check-fill me-1"></i> POS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cashier.orders') ? 'active' : '' }}" href="{{ route('cashier.orders') }}">
                        <i class="bi bi-receipt me-1"></i> View Orders
                    </a>
                </li>
                @endif

                <li class="nav-item logout-item mt-auto px-2">
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
        </nav>

        <main id="content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });

            // Optionally: keep sidebar open on desktop and only toggle on mobile
            const mql = window.matchMedia('(min-width: 769px)');
            function handleResize(e) {
                if (e.matches) {
                    sidebar.classList.remove('collapsed');
                } else {
                    sidebar.classList.add('collapsed');
                }
            }
            mql.addListener(handleResize);
            handleResize(mql);

            // Add event listeners for the chevron icon rotation
            const collapseElements = document.querySelectorAll('.collapse');
            collapseElements.forEach(collapseEl => {
                collapseEl.addEventListener('show.bs.collapse', function () {
                    const toggleLink = this.previousElementSibling;
                    const toggleIcon = toggleLink.querySelector('.toggle-icon');
                    if (toggleIcon) {
                        toggleIcon.classList.remove('bi-chevron-down');
                        toggleIcon.classList.add('bi-chevron-up');
                    }
                });

                collapseEl.addEventListener('hide.bs.collapse', function () {
                    const toggleLink = this.previousElementSibling;
                    const toggleIcon = toggleLink.querySelector('.toggle-icon');
                    if (toggleIcon) {
                        toggleIcon.classList.remove('bi-chevron-up');
                        toggleIcon.classList.add('bi-chevron-down');
                    }
                });
            });
        })();
    </script>
</body>
</html>