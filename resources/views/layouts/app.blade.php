<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk Lab</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">
    <nav class="bg-gray-800 shadow">
        <div class="flex flex-col items-center mb-1">
            <img src="{{ asset('img/logo2.png') }}" alt="Logo" class="h-24 w-24 rounded p-1">
        </div>
    </nav>

    <main class="py-4 px-2 mx-auto max-w-2xl w-full flex-1">
        @yield('content')
    </main>
    <footer class="bg-gray-800 py-3 px-4 text-center text-sm">
        &copy; {{ date('Y') }} Helpdesk Lab. All rights reserved.
    </footer>
</body>

</html>
