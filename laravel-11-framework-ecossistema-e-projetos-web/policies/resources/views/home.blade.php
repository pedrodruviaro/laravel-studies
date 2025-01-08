@extends('layouts.main_layout')
@section('content')
    <div class="py-5">

        @can('create', 'App\\Models\Post')
            <div class="container">
                <div class="mb-5">
                    <a href="{{ route('post.create') }}" class="btn btn-primary">Create post</a>
                </div>
            </div>
        @endcan

        @if ($posts->count() === 0)
            <p class="my-5 mx-auto">No posts to display</p>
        @else
            <div class="container">
                <div class="row">
                    <div class="col">
                        @foreach ($posts as $post)
                            @can('view', $post)
                                <x-post.card :$post />
                            @endcan
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
