@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <p class="display-6 text-info">Contact Page</p>

                <hr>

                @auth
                    <p>I'm Logged!</p>
                    <p>User: {{ auth()->user()->name }}</p>
                @endauth

                @guest
                    <p>I'm not Logged...</p>
                @endguest

            </div>
        </div>
    </div>
@endsection
