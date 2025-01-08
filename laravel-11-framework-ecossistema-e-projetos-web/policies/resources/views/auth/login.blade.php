@extends('layouts.main_layout')
@section('content')
    <div class="py-5 d-flex justify-content-center gap-4">
        <a href="{{ route('login_user', ['id' => 1]) }}" class="btn btn-large btn-outline-primary">Login Admin</a>
        <a href="{{ route('login_user', ['id' => 2]) }}" class="btn btn-large btn-outline-primary">Login User</a>
        <a href="{{ route('login_user', ['id' => 3]) }}" class="btn btn-large btn-outline-primary">Login Visitor</a>
    </div>
@endsection
