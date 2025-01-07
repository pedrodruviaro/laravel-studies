<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gates
        Gate::define('post.create', function (User $user) {
            return $user->role === 'admin' || $user->role === 'normal_user';
        });

        Gate::define('post.delete', function (User $user, Post $post) {
            return $user->role === 'admin' || $post->user_id === $user->id;
        });
    }
}
