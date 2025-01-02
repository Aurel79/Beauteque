<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite('resources/sass/app.scss')
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 text-white fs-4 border-bottom">
                Admin Panel
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.products.index') }}"
                    class="list-group-item list-group-item-action">Products</a>
                <a href="{{ route('admin.reviews.index') }}" class="list-group-item list-group-item-action">Reviews</a>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-light btn-sm logout-btn"onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="bi bi-lock-fill"></i> Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid mt-3">
                @yield('content')
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
    @include('sweetalert::alert')
    @stack('scripts')
</body>

</html>
