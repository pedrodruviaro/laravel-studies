<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pixel Positions</title>

    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])
</head>

<body class="bg-black text-white">
    <div class="px-10">
        <nav class="flex justify-between items-center gap-2 py-4 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Pixel Positions">
                </a>
            </div>

            <div class="space-x-6 font-bold">
                <a href="#">Jobs</a>
                <a href="#">Careers</a>
                <a href="#">Salaries</a>
                <a href="#">Companies</a>
            </div>

            @auth
                <div class="flex gap-2">
                    <a href="/jobs/create">Post a Job</a>

                    <form action="/logout" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Logout</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="flex gap-2">
                    <a href="/register">Register</a>
                    <a href="/login">Login</a>
                </div>
            @endguest
        </nav>

        <main class="my-10 w-full max-w-[986px] mx-auto px-4">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
