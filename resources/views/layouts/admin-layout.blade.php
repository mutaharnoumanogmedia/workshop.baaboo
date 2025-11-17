<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar Dashboard</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        /* Optional: Smooth scrolling for better UX */
        html {
            scroll-behavior: smooth;
        }


        .d-card {
            @apply bg-white p-6 rounded-xl shadow-lg border border-indigo-100;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans flex">

    <!-- 1. BACKDROP/OVERLAY (Visible only on mobile when sidebar is open) -->
    <div id="backdrop"
        class="fixed inset-0 bg-black opacity-0 transition-opacity duration-300 pointer-events-none lg:hidden z-40">
    </div>

    <!-- 2. SIDEBAR (The Navigation Panel) -->
    <aside id="sidebar"
        class="fixed top-0 left-0 h-screen w-64 bg-gray-900 text-white shadow-xl
                           transform -translate-x-full lg:translate-x-0 transition-transform duration-300
                           z-50 rounded-r-xl">

        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-2xl font-extrabold text-indigo-400">Gemini Admin</h1>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150 bg-indigo-600/50">
                <x-heroicon-s-home class="w-5 h-5 mr-3" />
                Dashboard
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150">
                <x-heroicon-s-users class="w-5 h-5 mr-3" />

                Users
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-150">
                <x-heroicon-s-cog class="w-5 h-5 mr-3" />
                Settings
            </a>
        </nav>
    </aside>

    <!-- 3. MAIN CONTENT AREA -->
    <div id="main-content" class="min-h-screen lg:ml-64 w-full transition-all duration-300">


        <!-- Header Bar (Only visible on small screens) -->

        <header class="sticky top-0 bg-white shadow-md p-4    z-30">

            <div class=" p-4 flex justify-between items-center container mx-auto px-4">
                <h2 class="text-xl font-bold text-gray-800 ">
                    @isset($header)
                        {{ $header }}
                    @endisset
                </h2>

                <!-- Mobile Menu Button -->
                <div class="ml-auto flex items-center" id="nav-actions">
                    <div class="relative inline-block text-left">
                        <button id="user-menu-button"
                            class="text-gray-600 hover:text-gray-900 p-2 transition duration-150 focus:outline-none rounded-full border border-gray hover:border-gray-300 flex w-auto"
                            onclick="document.getElementById('user-menu-dropdown').classList.toggle('hidden')">
                            <x-heroicon-s-user-circle class="w-6 h-6" />
                            {{ Auth::user()->name }}
                            <x-heroicon-s-chevron-down class="w-4 h-4 ml-1 mt-1" />
                        </button>
                        <div id="user-menu-dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    </div>

                    <button id="menu-button"
                        class="text-gray-600 hover:text-gray-900 p-2 rounded-lg transition duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </header>


        <!-- Page Content -->
        <main class="p-6 md:p-10  container mx-auto px-4">

            {{ $slot }}
        </main>
    </div>

    <!-- 4. JAVASCRIPT FOR TOGGLING THE SIDEBAR -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const menuButton = document.getElementById('menu-button');
        const backdrop = document.getElementById('backdrop');

        // Function to open the sidebar
        function openSidebar() {
            // Remove the hidden class (which is -translate-x-full)
            sidebar.classList.remove('-translate-x-full');
            // Show the backdrop and make it clickable
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-50');
        }

        // Function to close the sidebar
        function closeSidebar() {
            // Add the hidden class (which is -translate-x-full)
            sidebar.classList.add('-translate-x-full');
            // Hide the backdrop and disable pointer events
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-50');
        }

        // Toggle handler
        function toggleSidebar() {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }

        // Event Listeners
        menuButton.addEventListener('click', toggleSidebar);
        backdrop.addEventListener('click', closeSidebar);

        // Optional: Close sidebar if screen is resized from mobile to desktop
        window.addEventListener('resize', () => {
            // Check if the screen size is large (lg: 1024px in Tailwind default)
            if (window.innerWidth >= 1024) {
                // Ensure sidebar is shown and backdrop is hidden when moving to desktop view
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-50');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            } else {
                // Ensure sidebar is hidden when moving from desktop to mobile view
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Initialize state for large screens (ensures sidebar is always open on desktop load)
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
        } else {
            // Ensure mobile state is correct on load
            sidebar.classList.add('-translate-x-full');
        }
    </script>
</body>

</html>
