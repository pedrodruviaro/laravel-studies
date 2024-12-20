@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row bg-black text-white">
            <div class="col align-content-center">
                <p class="display-6">{{ env('APP_NAME') }}</p>
            </div>
            <div class="col d-flex justify-content-end align-items-center gap-5 p-3">
                <div>
                    <span>Usuário: <strong class="text-info">{{ Auth::user()->name }}</strong></span>
                    <span>{{ auth()->user()->email }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col text-center">
                <span class="display-3">PÁGINA INICIAL</span>
                <hr>
                <a href="{{ route('contact') }}">Contato</a>
            </div>
        </div>
    </div>
@endsection
