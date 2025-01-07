<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('post.store') }}" method="post">
            @csrf

            <div class="mt-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                    autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="content" :value="__('Content')" />
                <x-text-input id="content" class="block mt-1 w-full" type="text" name="content"
                    :value="old('content')" />
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>


            <x-primary-button class="mt-3">
                {{ __('Create') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
