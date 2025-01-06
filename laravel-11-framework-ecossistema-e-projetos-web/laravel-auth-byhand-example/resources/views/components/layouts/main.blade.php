<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    {{-- JS --}}
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>

<body>

    @auth
        <x-user-bar />
    @endauth

    {{ $slot }}

</body>

</html>
