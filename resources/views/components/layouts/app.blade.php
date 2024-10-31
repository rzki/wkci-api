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
            <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    </body>
</html>
