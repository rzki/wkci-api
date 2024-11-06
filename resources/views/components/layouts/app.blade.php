<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title .' - Jakarta Dental Exhibition 2024' ?? 'Jakarta Dental Exhibition 2024' }}</title>
        <link rel="shortcut icon" href="{{ asset('images/icons/logo_new_square.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/brands.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/regular.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/solid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
        <!-- Styles -->
        @vite('resources/sass/app.scss')
        <!-- Select2 + Bootstrap Theme -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>
    <body>
        @include('layouts.nav')
            @include('layouts.sidenav')
            <main class="content">
                {{-- TopBar --}}
                @include('layouts.topbar')
                {{ $slot }}
            </main>

            @yield('scripts')
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    </body>
</html>
