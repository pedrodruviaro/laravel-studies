<x-layouts.main-layout>
    <div class="container">
        <div class="row">
            <div class="col">

                <ul class="display-6">
                    @guest
                        <li>
                            <a href="{{ route('loginAsAdmin') }}">Login as admin</a>
                        </li>
                        <li>
                            <a href="{{ route('loginAsGuest') }}">Login as guest</a>
                        </li>
                    @else
                        @can('user_is_admin')
                            <li>
                                <a href="{{ route('admin') }}">ADMIN!</a>
                            </li>
                        @endcan
                    @endguest
                </ul>

            </div>
        </div>
    </div>
</x-layouts.main-layout>
