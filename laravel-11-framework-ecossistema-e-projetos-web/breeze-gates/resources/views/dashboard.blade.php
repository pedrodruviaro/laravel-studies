<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @empty($posts->count())
            <div class="mx-auto text-center">
                <p class="text-lg mb-4">Sem posts para exibir</p>
                <x-primary-button as="a" href="{{ route('post.create') }}">Create</x-primary-button>
            </div>
        @else
            @can('post.create')
                <div class="pb-6">
                    <x-primary-button as="a" href="{{ route('post.create') }}">Create</x-primary-button>
                </div>
            @endcan
        @endempty

        <div class="space-y-3">
            @foreach ($posts as $post)
                <x-post.card :$post />
            @endforeach
        </div>
    </div>
</x-app-layout>
