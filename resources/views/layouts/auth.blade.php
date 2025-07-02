<!--
    Authentication layout for the Pazar Website Admin panel.
    This layout is used for login, register, and other authentication-related pages.
    It provides a minimal structure with global styles and SweetAlert2 for notifications.
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
        SweetAlert2 for alert popups.
    -->
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="dark bg-bg-dark text-gray-custom min-h-screen">
    <!--
        Content section: Child authentication views inject their main content here using @section('content').
    -->
    @yield('content')
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