<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MainController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();

        return view('home', ['posts' => $posts]);
    }

    public function update($id): void
    {
        $post = Post::findOrFail($id);

        // check if user has permission
        if (!Auth::user()->can('update', $post)) {
            abort(401);
        }

        dd('update post');
    }

    public function destroy($id): void
    {
        $post = Post::findOrFail($id);

        // check if user has permission
        if (!Auth::user()->can('delete', $post)) {
            abort(401);
        }

        dd('delete post');
    }

    public function create(): void
    {

        // check if user has permission
        // if (!Auth::user()->can('create', Post::class)) {
        //     abort(401);
        // }

        // dd('create post!');

        $response = Gate::inspect('create', Post::class);

        if ($response->allowed()) {
            dd("Can create");
        } else {
            if ($response->status() === 403) {
                abort(403, $response->message());
            }

            abort(401);
        }
    }
}
