<!--
    Main layout file for the Pazar Website Admin panel.
    This file defines the overall HTML structure, includes global CSS/JS, and provides the header, sidebar, and main content area for all admin pages.
    Use this layout as the base for all admin views by extending it.
-->
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <!--
        Meta tags and page title.
        The title can be set by child views using @section('title').
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pazar Website Admin')</title>
    <link rel="icon" href="img/Logo.ico" type="image/x-icon">
    <!--
        Tailwind CSS for styling (loaded via CDN).
        Alpine.js for frontend interactivity (e.g., sidebar, dropdowns).
        SweetAlert2 for alert popups.
    -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tailwind theme configuration for custom colors and dark mode.
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'accent': '#BF161C',
                        'gray-custom': '#E0FBFC',
                        'bg-dark': '#253237',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Custom style for the sidebar to ensure scrolling works properly */
        .sidebar-content {
            height: calc(100vh - 3.75rem);
            overflow-y: auto;
        }
        /* Add padding to bottom of sidebar to ensure last item is visible */
        .sidebar-nav {
            padding-bottom: 2rem;
        }
    </style>
</head>
<body x-data="{ sidebarOpen: true }" 
      class="dark bg-bg-dark text-gray-custom min-h-screen transition-all duration-200">
    
    <!--
        Header section: Contains the sidebar toggle, page title, and user profile dropdown.
        The header is fixed at the top for persistent navigation.
    -->
    <header class="fixed top-0 z-30 w-full bg-bg-dark border-b border-gray-700 shadow">
        <div class="flex items-center justify-between h-16 px-4">
            <!--
                Sidebar toggle button: Allows users to show/hide the sidebar on smaller screens.
            -->
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!--
                Application title.
            -->
            <div>
                <h1 class="text-xl font-bold text-gray-custom">Pazar Website Admin</h1>
            </div>
            <!--
                User profile dropdown: Shows user info and provides links to profile and logout.
            -->
            <div x-data="{ open: false }" class="relative">
                <!-- Profile button: Shows user avatar or default icon. -->
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center overflow-hidden">
                        @if(session('user') && session('user')['u_profile_image'])
                            <img src="{{ config('app.user_storage_url') . '/' . session('user')['u_profile_image'] }}" 
                                alt="Profile" 
                                class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @endif
                    </div>
                </button>
                <!--
                    Dropdown menu: Contains user info, profile link, and logout button.
                    Uses Alpine.js for show/hide transitions.
                -->
                <div x-show="open" 
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-100" 
                    x-transition:enter-start="transform opacity-0 scale-95" 
                    x-transition:enter-end="transform opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-75" 
                    x-transition:leave-start="transform opacity-100 scale-100" 
                    x-transition:leave-end="transform opacity-0 scale-95" 
                    class="absolute right-0 mt-2 w-64 bg-gray-800 rounded-md shadow-lg py-4 z-50">
                    @if(session('user'))
                        <div class="px-4 py-2 border-b border-gray-700">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center mr-3 overflow-hidden">
                                    <!-- User profile image or default icon -->
                                    @if(session('user') && session('user')['u_profile_image'])
                                        <img src="{{ config('app.user_storage_url') . '/' . session('user')['u_profile_image'] }}?t={{ time() }}" 
                                            alt="Profile" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-200">{{ session('user')['u_name'] }}</p>
                                    <p class="text-xs text-gray-400">{{ session('user')['u_email'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mt-2">
                        <!-- Link to user profile page -->
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Profile
                            </div>
                        </a>
                        <!-- Logout form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--
        Sidebar section: Contains navigation links for the admin panel.
        The sidebar is included from a separate Blade component for reusability.
    -->
    <div class="flex pt-2">
        @include('components.sidebar')

        <!--
            Main content area: Displays the page title, alert messages, and the content of each child view.
            The sidebar can be toggled to show/hide, affecting the main content's margin.
        -->
        <main 
            :class="sidebarOpen ? 'ml-64' : 'ml-0'"
            class="flex-1 min-h-screen p-6 pt-20 transition-all duration-300">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">@yield('page-title', 'Dashboard')</h1>
            </div>
            <!--
                Alert messages for success, info, and error, shown based on session data.
            -->
            @if(session('success'))
                <div class="p-4 mb-6 text-green-100 bg-green-800 border-l-4 border-green-500" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('info'))
                <div class="p-4 mb-6 text-green-100 bg-yellow-800 border-l-4 border-yellow-500" role="alert">
                    {{ session('info') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-6 text-red-100 bg-red-800 border-l-4 border-red-500" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            <!--
                Content section: Child views inject their main content here using @section('content').
            -->
            @yield('content')
        </main>
    </div>
    <!--
        SweetAlert2 popup: Shows a notification if 'swal_msg' exists in the session.
    -->
    <script>
        @if(session('swal_msg'))
            Swal.fire({
                icon: '{{ session('swal_type', 'info') }}',
                title: '{{ session('swal_title', 'Notification') }}',
                text: '{{ session('swal_msg') }}',
                timer: {{ session('swal_timer', 3000) }}
            });
        @endif
    </script>
</body>
</html>