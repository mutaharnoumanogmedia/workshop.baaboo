<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - CoursePro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @yield('header')
    <style>
        :root {
            --primary-orange: #FF6B35;
            --dark-orange: #E55A2B;
            --light-orange: #FF8C5A;
            --light-bg: #FFF5F0;
            --bs-primary-rgb: rgba(255, 107, 53, 1);
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .bg-primary {
            background-color: var(--primary-orange) !important;
        }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
            background-color: var(--primary-orange);
            color: white;
        }
        .nav-link{
            color: var(--primary-orange);
        }

        .navbar-coursepro {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-coursepro {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
            font-weight: 600;
        }

        .btn-coursepro:hover {
            background-color: var(--dark-orange);
            border-color: var(--dark-orange);
            color: white;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-orange);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        .sidebar {
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
            padding: 0;
        }

        .sidebar-toggle {
            color: var(--primary-orange);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: var(--light-bg);
            color: var(--primary-orange);
            border-left: 4px solid var(--primary-orange);
        }

        .sidebar-menu i {
            width: 25px;
            margin-right: 10px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .workshop-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .workshop-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .workshop-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .progress-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.95);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .workshop-content {
            padding: 20px;
        }

        .category-badge {
            background-color: var(--light-bg);
            color: var(--primary-orange);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            /* full height */
            width: 250px;
            /* match your sidebar width */
            overflow-y: auto;
            /* scroll if content is long */
            background: #fff;
            /* or your sidebar background */
            border-right: 1px solid #ddd;
            z-index: 1000;
        }

        /* .content-wrapper {
            margin-left: 250px;
            width: calc(100% - 250px);
        } */

        @media (max-width: 992px) {
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        .workshop-card {
            background-color: white;
            border-radius: 24px;
            border: 1px solid rgba(255, 107, 53, 0.15);
            box-shadow: 0 15px 30px rgba(17, 24, 39, 0.06);
            padding: 32px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .workshop-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 45px rgba(17, 24, 39, 0.12);
        }

        .badge-soft {
            background-color: var(--light-bg);
            color: var(--primary-orange);
        }

        nav .nav-link {
            color: #374151;
            font-weight: 500;
        }

        nav .nav-link:hover {
            color: var(--primary-orange);
        }

        nav .nav-link.active {
            color: var(--primary-orange) !important;
            font-weight: 700;
        }

    </style>
    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm  navbar-light navbar-coursepro">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold me-5" href="#" style="color: var(--primary-orange);">
                <img src="{{ url('template/logo.png') }}" class="h-auto img-fluid" style="width: 100px" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('user.dashboard')) active @endif"
                            href="{{ route('user.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('user.workshop*')) active @endif"
                            href="{{ route('user.workshops') }}">Workshops</a>
                    </li>

                </ul>
                <div class="ms-auto d-flex align-items-center">
                    {{-- <button class="btn btn-link position-relative me-3">
                        <i class="fas fa-bell" style="color: var(--primary-orange); font-size: 20px;"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </button> --}}
                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar me-2">{{ Auth::user()->initials }}</div>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item bg-primary text-white" href="#">
                                        <i class="bi bi-person me-2"></i> {{ Auth::user()->full_name }}
                                    </a>
                                </li>
                                 <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}"><i
                                            class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                                </li>
                                {{-- <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a>
                                </li> --}}
                                {{-- <li>
                                    <hr class="dropdown-divider">
                                </li> --}}
                                <li><a class="dropdown-item" href="javascript:void(0)"
                                        onclick="document.getElementById('logout-form').submit()"><i
                                            class="bi bi-box-arrow-right me-2"></i>Sign
                                        Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="overlay"></div>

    <main>
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                {{-- <div class="col-lg-2 col-xl-2 p-0 sidebar " id="sidebar">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0 fw-bold">Menu</h6>
                    </div>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('user.dashboard') }}"
                                class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-th-large"></i> Dashboard
                            </a>
                        </li>
                        </li>
                        <li>
                            <a href="{{ route('user.workshops') }}"
                                class="{{ request()->routeIs('user.workshops') ? 'active' : '' }}">
                                <i class="fas fa-book-open"></i> My Workshops
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.certificates') }}"
                                class="{{ request()->routeIs('user.certificates') ? 'active' : '' }}">
                                <i class="fas fa-certificate"></i> Certificates
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.schedule') }}"
                                class="{{ request()->routeIs('user.schedule') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt"></i> Schedule
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.favorites') }}"
                                class="{{ request()->routeIs('user.favorites') ? 'active' : '' }}">
                                <i class="fas fa-heart"></i> Favorites
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.downloads') }}"
                                class="{{ request()->routeIs('user.downloads') ? 'active' : '' }}">
                                <i class="fas fa-download"></i> Downloads
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.settings') }}"
                                class="{{ request()->routeIs('user.settings') ? 'active' : '' }}">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                           
                        </li>
                    </ul>
                </div> --}}
                <div class="content-wrapper p-lg-4">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-5 text-center text-muted small position-relative bottom-0 w-100 bg-light">
        © {{ now()->year }} — {{ env('APP_NAME') }}.
    </footer>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    </script> --}}
    @stack('scripts')

</body>

</html>
