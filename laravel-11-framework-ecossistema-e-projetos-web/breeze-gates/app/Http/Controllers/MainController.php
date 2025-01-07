<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        // get all posts and the data of the user who creates it
        $posts = Post::with('user')->latest()->get();

        return view('dashboard', ['posts' => $posts]);
    }

    public function create_post()
    {
        if (Gate::denies('post.create')) {
            abort(403, 'Você não tem autorização para criar um post');
        }

        return view('create-post');
    }

    public function delete_post($id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('post.delete', $post)) {
            abort(403, 'Você não tem autorização para apagar um post');
        }

        $post->delete();

        return redirect()->route('dashboard');
    }

    public function store(Request $request): RedirectResponse
    {
        if (Gate::denies('post.create')) {
            abort(403, 'Você não tem autorização para criar um post');
        }

        $request->validate(
            [
                'title' => ['required', 'string', 'min:3', 'max:100'],
                'content' => ['required', 'string', 'min:3', 'max:1000'],
            ],
            [
                'title.required' => 'The title field is required',
                'title.string' => 'The title field must be a string',
                'title.min' => 'The title field must be at least 3 characters',
                'title.max' => 'The title field must not exceed 100 characters',
                'content.required' => 'The content field is required',
                'content.string' => 'The content field must be a string',
                'content.min' => 'The content field must be at least 3 characters',
                'content.max' => 'The content field must not exceed 1000 characters',
            ]
        );

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('dashboard');
    }
}
