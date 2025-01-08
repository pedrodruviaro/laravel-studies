@props(['post'])

<div class="card bg-dark p-3 mt-3">
    <div class="d-flex justify-content-between">
        <div>
            Author: <span class="text-info">{{ $post->user->name }}</span>
        </div>

        <div class="text-sm text-light">
            {{ $post->created_at }}
        </div>
    </div>


    <div class="mt-3">
        <h4>{{ $post->title }}</h4>
        <p>{{ $post->content }}</p>
    </div>

    <div class="d-flex justify-content-end gap-3">

        @can('update', $post)
            <a href="{{ route('post.update', ['id' => $post->id]) }}" class="btn btn-primary">Editar</a>
        @endcan

        @can('delete', $post)
            <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="btn btn-danger">Remover</a>
        @endcan

    </div>
</div>
