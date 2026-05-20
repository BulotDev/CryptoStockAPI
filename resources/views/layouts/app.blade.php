<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="https://assets.coingecko.com/coins/images/1/large/bitcoin.png">

    <!-- Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #050816;
            color: #eef2ff;
        }

        .min-vh-100.bg-dark {
            background-color: #050816 !important;
        }

        .navbar-dark {
            background-color: #0f172a !important;
            border-color: rgba(148, 163, 184, 0.16) !important;
        }

        .navbar-dark .navbar-brand,
        .navbar-dark .nav-link,
        .navbar-dark .navbar-text {
            color: #cbd5e1 !important;
        }

        .navbar-dark .nav-link.active,
        .navbar-dark .nav-link:hover {
            color: #ffffff !important;
        }

        .bg-dark {
            background-color: #0f172a !important;
        }

        .bg-secondary {
            background-color: #111827 !important;
        }

        .bg-light {
            background-color: #050816 !important;
        }

        .bg-white {
            background-color: #0f172a !important;
            color: #eef2ff !important;
        }

        .dropdown-menu {
            background: #111827 !important;
            border-color: rgba(148, 163, 184, 0.16) !important;
        }

        .dropdown-item {
            color: #cbd5e1 !important;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: rgba(56, 189, 248, 0.12) !important;
            color: #ffffff !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-vh-100 bg-dark text-white pb-2">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-secondary shadow-sm">
                <div class="container py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="container">
            {{ $slot }}
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let myModalEl = document.querySelector('[data-modal="1"]');
        if (myModalEl) {
            const myModal = new bootstrap.Modal(myModalEl);
            myModal.show();
        }
    </script>
</body>

</html>
