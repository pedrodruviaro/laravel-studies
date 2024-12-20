@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card p-5">
                <form action="{{ route('password.update') }}" method="post">
                    @csrf

                    <p class="display-6 text-center">Redefinir senha</p>

                    <input type="text" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input autofocus type="mail" name="email" id="email" class="form-control"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation">Confirmação da senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <div>
                            <a href="{{ route('login') }}">Voltar</a>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-secondary px-5">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
