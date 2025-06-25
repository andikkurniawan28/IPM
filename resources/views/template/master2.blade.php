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
</head>

<body>

    {{-- @include('template.navbar') --}}

    <!-- Main Content -->
    <main class="container-fluid py-4 px-4">
        @yield('content')
    </main>

    {{-- @include('template.floating-button') --}}

    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 1000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                timer: 1000,
                showConfirmButton: false
            });
        @endif

        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += `- {{ $error }}\n`;
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: errorMessages,
                customClass: {
                    popup: 'text-start'
                }
            });
        @endif
    </script>
</body>
</html>
