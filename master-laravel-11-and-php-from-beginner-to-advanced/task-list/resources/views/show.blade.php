@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <p>{{ $task->description }}</p>

    @if ($task->long_description)
        <p>{{ $task->long_description }}</p>
    @endif

    <p>{{ $task->created_at }}</p>
    <p>{{ $task->updated_at }}</p>

    <p>
        @if ($task->completed)
            Completed
        @else
            Not completed
        @endif
    </p>

    <div>
        <a href="{{ route('tasks.edit', ['task' => $task]) }}">Edit</a>
    </div>

    <div>
        <form action="{{ route('tasks.toggle-complete', ['task' => $task]) }}" method="POST">
            @csrf
            @method('PUT')

            <button type="submit">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>
    </div>

    <div>
        <form method="POST" action="{{ route('tasks.destroy', ['task' => $task]) }}">
            @csrf
            @method('DELETE')

            <button type="submit">Remove task</button>
        </form>
    </div>
@endsection
