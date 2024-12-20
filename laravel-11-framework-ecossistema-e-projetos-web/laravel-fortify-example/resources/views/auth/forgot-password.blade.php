@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class=" card p-5">
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <p class="display-6 text-center">Recuperar senha</p>
                    <div class="mb-3">
                        <label for="email">Indique o seu endereço de email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mt-4 d-flex justify-content-between">
                        <div>
                            <a href="{{ route('login') }}">Já tem uma conta?</a>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-secondary px-5">Enviar redefinição</button>
                        </div>
                    </div>
                </form>

                @if (session('status'))
                    <div class="text-center mt-5">Email enviado para o seu endereço de email</div>
                    <a href="{{ route('login') }}">Voltar</a>
                @endif

            </div>
        </div>
    </div>
@endsection
