<div class="container-fluid bg-dark">
    <div class="row align-items-center">
        <div class="col p-3">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Laravel Studies">
        </div>
        <div class="col text-end">
            <div class="d-flex gap-4 justify-content-end">

                @auth
                    <p>{{ Auth::user()->email }}</p>

                    <a href="{{ route('logout') }}">Logout</a>
                @endauth
            </div>
        </div>
    </div>
</div>
