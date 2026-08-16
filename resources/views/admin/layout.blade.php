<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Aero Parking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    {{-- The public site's "optimized" Bootstrap build is a purged subset containing
         only the classes that page actually uses (nav, container, btn, etc). The
         admin dashboard uses far more of Bootstrap (nav-tabs, cards, tables, forms),
         so it needs the full, unpurged build instead. --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.optimized.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') . '?' . env('APP_VERSION') }}">
</head>
<body>
@auth
    <nav class="navbar navbar-expand admin-navbar">
        <div class="container-fluid">
            <span class="navbar-brand">Aero Parking Admin</span>
            <span class="navbar-text me-3 ms-auto">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Log out</button>
            </form>
        </div>
    </nav>
@endauth

<main class="container my-4">
    @yield('content')
</main>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/js/main.js') }}" type="module"></script>
@yield('scripts')
</body>
</html>
