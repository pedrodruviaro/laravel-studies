@extends('layout.main_layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">

                    <!-- logo -->
                    <div class="text-center p-3">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Notes logo">
                    </div>

                    <!-- form -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="/login" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="text_username" class="form-label">Username</label>
                                    <input type="text" class="form-control bg-dark text-info" name="text_username"
                                        value="{{ old('text_username') }}">
                                    @error('text_username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="text_password" class="form-label">Password</label>
                                    <input type="password" class="form-control bg-dark text-info" name="text_password"
                                        value="{{ old('text_password') }}">
                                    @error('text_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-secondary w-100">LOGIN</button>
                                </div>
                            </form>

                            {{-- invalid login --}}
                            @if (session('login_error'))
                                <div class="alert alert-danger text-center">
                                    {{ session('login_error') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- copy -->
                    <div class="text-center text-secondary mt-3">
                        <small>&copy; <?= date('Y') ?> Notes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
