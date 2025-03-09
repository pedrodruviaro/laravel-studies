<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    $tasks = Task::latest()->paginate(15);
    return view('index', compact('tasks'));
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', compact('task'));
})->name('tasks.edit');

Route::post('/tasks', function (TaskRequest $request) {
    $data = $request->validated();
    Task::create($data);

    return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    $data = $request->validated();
    $task->update($data);

    return redirect()->route('tasks.show', ['task' => $task])->with('success', 'Task updated successfully!');
})->name('tasks.update');

Route::put('/tasks/{task}/toggle-complete', function (Task $task) {
    $task->toggleComplete();

    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');

Route::get('/tasks/{task}', function (Task $task) {
    return view('show', compact('task'));
})->name('tasks.show');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');
