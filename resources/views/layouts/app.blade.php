<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Monitoring System</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Scripts Stack -->
    @stack('styles')
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">Traffic Monitoring</h1>
            <div class="space-x-4">
                <a href="{{ route('dashboard') }}"
                    class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('dashboard') ? 'font-bold text-blue-600' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('cameras.index') }}"
                    class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('cameras.*') ? 'font-bold text-blue-600' : '' }}">
                    CCTV Management
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts Stack -->
    @stack('scripts')
</body>

</html>
