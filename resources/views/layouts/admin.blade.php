<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Helpdesk Lab</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 flex flex-col justify-between py-8 px-4">
            <div>
                <div class="flex flex-col items-center mb-8">
                    <img src="{{ asset('img/logo2.png') }}" alt="Logo" class="h-24 w-24 rounded p-1 mb-2">
                </div>
                <nav class="flex flex-col gap-2">
                    <a href="/admin"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition {{ request()->is('admin') ? 'bg-gray-700' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.history') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition {{ request()->is('admin/history') ? 'bg-gray-700' : '' }}">
                        History
                    </a>
                    <a href="{{ route('admin.export') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition">
                        Export Excel
                    </a>
                    <a href="{{ route('admin.ip-mapping') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-700 transition {{ request()->is('admin/ip-mapping') ? 'bg-gray-700' : '' }}">
                        IP Mapping
                    </a>
                </nav>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full flex items-center gap-2 px-3 py-2 rounded hover:bg-red-700 transition text-red-300 font-semibold">
                    Logout
                </button>
            </form>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 py-8 px-6">
                @yield('content')
            </main>
            <footer class="bg-gray-800 p-4 text-center text-sm">
                &copy; {{ date('Y') }} Helpdesk Lab. All rights reserved.
            </footer>
        </div>
    </div>
</body>

</html>
