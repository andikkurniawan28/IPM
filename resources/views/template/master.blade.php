<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MDP (Monitoring Dalam Pabrik)')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    @include('template.style')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        main {
            min-height: 85vh;
        }
    </style>
    @yield('style')
</head>

<body>

    @include('template.navbar')

    <!-- Main Content -->
    <main class="container-fluid py-4 px-4">
        @yield('content')
    </main>

    <footer class="text-center text-light py-3 border-top bg-dark">
        <small>&copy; {{ date('Y') }} <a href="https://wa.me/6285733465399" target="_blank" class="text-light">PT. Optima Teknologi Industri.</a></small>
    </footer>

    @include('template.session')

    @yield('scripts')


</body>
</html>
