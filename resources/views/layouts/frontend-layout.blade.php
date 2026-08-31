<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contact</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
 @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))) 
     {{-- <link rel="stylesheet" href=" {{ URL::asset('css/custom.navbar.css') }}"> --}}
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

     @else 

     @endif 
</head>

<body class="d-flex flex-column align-items-center justify-content-center vh-100 bg-body-tertiary' : 'd-flex flex-column w-100 vh-100 bg-body-tertiary">
    @include('include.header')
    <main class="container-fluid ">
        @yield('content')
    </main>
    @include('include.footer')
    @stack('scripts')
</body>
</html>
