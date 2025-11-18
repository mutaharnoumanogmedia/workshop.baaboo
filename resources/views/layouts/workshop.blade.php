<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CoursePro')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-orange: #FF6B35;
            --dark-orange: #E55A2B;
            --light-orange: #FF8C5A;
            --light-bg: #FFF5F0;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        }

        .sidebar-toggle {
            color: var(--primary-orange);
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }
    </style>
    @stack('inline-styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-coursepro sticky-top">
        <div class="container-fluid px-4">
            <button class="sidebar-toggle d-lg-none border-0 bg-transparent me-3" type="button">
                <i class="bi bi-list fs-3 text-warning"></i>
            </button>
            <a class="navbar-brand fw-bold" href="{{ url('/my-workshops') }}" style="color: var(--primary-orange);">
                <i class="bi bi-play-btn-fill me-2"></i>CoursePro
            </a>
            <div class="d-flex align-items-center ms-auto">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar me-2">JS</div>
                        <span class="d-none d-md-inline">John Smith</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="overlay"></div>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 text-center text-muted small">
        © {{ now()->year }}  Prototype — UI only.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');

            if (!sidebar && sidebarToggle) {
                sidebarToggle.classList.add('d-none');
            }

            if (sidebarToggle && sidebar && overlay) {
                sidebarToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });

                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

