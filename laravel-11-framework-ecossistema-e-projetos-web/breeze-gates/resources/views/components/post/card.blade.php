@props(['post'])

<div>
    <div
        class="{{ $post->user_id === Auth::user()->id ? 'bg-blue-50' : 'bg-white' }} overflow-hidden rounded shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between">
                <div>
                    <span class="text-gray-500 me-3">Author:</span>
                    <span class="text-blue-600">{{ $post->user->name }}</span>
                </div>

                <div>
                    <span class="text-gray-500 me-3">Created at:</span>
                    <span>{{ $post->created_at }}</span>
                </div>
            </div>

            <div class="mt-4">
                <h2 class="text-xl font-bold">{{ $post->title }}</h2>
                <p class="mt-3">{{ $post->content }}</p>
            </div>

            @can('post.delete', $post)
                <div class="mt-3 text-end">
                    <x-primary-button as="a"
                        href="{{ route('post.delete', ['id' => $post->id]) }}">Delete</x-primary-button>
                </div>
            @endcan
        </div>
    </div>
</div>
