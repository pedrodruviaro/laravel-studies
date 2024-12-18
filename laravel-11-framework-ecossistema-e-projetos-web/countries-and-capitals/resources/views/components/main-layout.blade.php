<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} | Countries & Capitals</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}" defer></script>

</head>

<body>
    <x-logo />

    <main>
        {{ $slot }}
    </main>

    <x-footer />

</body>

</html>
