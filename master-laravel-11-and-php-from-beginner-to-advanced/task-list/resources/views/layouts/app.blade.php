<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>Task List</title>

    @yield('styles')
</head>

<body class="container mx-auto my-10 max-w-lg">
    <h1 class="font-bold text-2xl">
        @yield('title')
    </h1>

    {{-- session flash messages --}}
    @if (session()->has('success'))
        <div x-data="{ flash: true }">
            <div x-show="flash"
                class="relative mb-10 rounded-lg text-lg text-green-800 border border-green-400 bg-green-100 px-4 py-3"
                role="alert">
                <strong class="font-bold">Success!</strong>
                <div>{{ session('success') }}</div>


                <div class="right-2 top-0 absolute">
                    <button @click="flash = false">&times;</button>
                </div>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

</body>

</html>
