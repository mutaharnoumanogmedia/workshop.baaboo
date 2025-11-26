<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        /* Custom color scheme - Orange (#ff5e1c) and Black */
        :root {
            --bs-primary: #ff5e1c;
            --bs-primary-rgb: 255, 94, 28;
            --bs-primary-dark: #e54f10;
            --bs-primary-light: #ff7640;
            --sidebar-bg: #1a1a1a;
            --sidebar-hover: #2d2d2d;
        }

        /* Override Bootstrap primary colors */
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .btn-primary:hover {
            background-color: var(--bs-primary-dark);
            border-color: var(--bs-primary-dark);
        }

        .bg-primary {
            background-color: var(--bs-primary) !important;
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }

        .border-primary {
            border-color: var(--bs-primary) !important;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background-color: var(--sidebar-bg);
            z-index: 1050;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
            border-radius: 1rem;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }

        #sidebar.show {
            transform: translateX(0);
        }

        /* Sidebar always visible on large screens */
        @media (min-width: 992px) {
            #sidebar {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 260px;
            }

            #menu-button {
                display: none;
            }
        }

        /* Backdrop */
        .backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        .backdrop.show {
            display: block;
        }

        /* Sidebar Navigation Links */
        .sidebar-nav a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.15s ease-in-out;
            margin-bottom: 0.5rem;
        }

        .sidebar-nav a:hover {
            background-color: var(--sidebar-hover);
        }

        .sidebar-nav a.active {
            background-color: var(--bs-primary);
        }

        .sidebar-nav a i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        /* Header Styles */
        .header-top {
            position: sticky;
            top: 0;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1030;
        }

        /* Card Styles */
        .d-card {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 94, 28, 0.1);
        }

        /* User Menu Dropdown */
        .user-menu-btn {
            border: 1px solid #dee2e6;
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            background-color: transparent;
            transition: all 0.15s ease-in-out;
        }

        .user-menu-btn:hover {
            border-color: #adb5bd;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Backdrop/Overlay -->
    <div id="backdrop" class="backdrop"></div>

    <!-- Sidebar -->
    <aside id="sidebar">
        <!-- Sidebar Header -->
        <div class="p-4 border-bottom border-secondary">
            <h1 class="h3 fw-bold mb-0" style="color: var(--bs-primary);">baaboo Workshop</h1>
        </div>

        <!-- Navigation Links -->
        <nav class="sidebar-nav p-3">
            <a href="{{ route('admin.dashboard') }}" class="@if (request()->routeIs('admin.dashboard')) active @endif">
                <i class="bi bi-house-door-fill"></i>
                Dashboard
            </a>
            <a href="#" class="@if (request()->routeIs('admin.programs.*')) active @endif">
                <i class="bi bi-journal-text"></i>
                Programs
            </a>
            <a href="{{ route('admin.workshops.index') }}" class="@if (request()->routeIs('admin.workshops.*')) active @endif">
                <i class="bi bi-calendar-event"></i>
                Workshops
            </a>
            <a href="#" class="@if (request()->routeIs('admin.modules.*')) active @endif">
                <i class="bi bi-grid-3x3-gap"></i>
                Modules
            </a>
            <a href="{{ route('admin.users.index') }}" class="@if (request()->routeIs('admin.users.*')) active @endif">
                <i class="bi bi-people-fill"></i>
                User Management
            </a>


            <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div id="main-content" class="min-vh-100">
        <!-- Header Bar -->
        <header class="header-top">
            <div class="container-fluid px-4 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h4 fw-bold text-dark mb-0">
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </h2>

                    <div class="d-flex align-items-center gap-2">
                        <!-- User Menu Dropdown -->
                        <div class="dropdown">
                            <button class="btn user-menu-btn d-flex align-items-center gap-2" type="button"
                                id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i>
                                <span class="d-none d-sm-inline">{{ Auth::user()->first_name }}</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i
                                            class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>

                        <!-- Mobile Menu Button -->
                        <button id="menu-button" class="btn btn-outline-secondary d-lg-none">
                            <i class="bi bi-list fs-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="container-fluid px-4 py-4">
            {{ $slot }}
        </main>
    </div>


    <form action="logout" method="post" id="logout-form">@csrf</form>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const menuButton = document.getElementById('menu-button');
        const backdrop = document.getElementById('backdrop');

        function openSidebar() {
            sidebar.classList.add('show');
            backdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        }

        function toggleSidebar() {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // Event Listeners
        if (menuButton) {
            menuButton.addEventListener('click', toggleSidebar);
        }

        backdrop.addEventListener('click', closeSidebar);

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        });

        // Initialize state
        if (window.innerWidth < 992) {
            sidebar.classList.remove('show');
        }
    </script>
</body>

</html>
