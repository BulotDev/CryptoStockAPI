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
            background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 22%),
                radial-gradient(circle at bottom right, rgba(99, 102, 241, 0.14), transparent 18%),
                linear-gradient(180deg, #050816 0%, #070810 100%);
            min-height: 100vh;
            color: #edf2ff;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            width: 100%;
            max-width: 900px;
            border-radius: 2rem;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(15, 23, 42, 0.9);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
        }

        .auth-side {
            background: linear-gradient(180deg, rgba(56, 189, 248, 0.16), rgba(99, 102, 241, 0.12));
        }

        .auth-side h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .auth-side p {
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.75;
            margin-bottom: 2rem;
        }

        .auth-form {
            padding: 2.5rem;
            background: rgba(15, 23, 42, 0.96);
        }

        .auth-form h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-form p {
            color: #94a3b8;
            margin-bottom: 1.5rem;
        }

        .form-control,
        .form-check-label {
            color: #f8fafc;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.9);
            border-color: rgba(148, 163, 184, 0.18);
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.96);
            border-color: rgba(56, 189, 248, 0.5);
            box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.18);
        }

        .btn-google {
            background: #ffffff;
            color: #0f172a;
            font-weight: 600;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .btn-google:hover {
            background: #f8fafc;
        }

        .auth-footer {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .auth-card {
                border-radius: 1.5rem;
            }

            .auth-side {
                display: none;
            }

            .auth-form {
                padding: 2rem;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
