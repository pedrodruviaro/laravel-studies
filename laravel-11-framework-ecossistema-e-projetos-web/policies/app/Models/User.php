<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    use SoftDeletes;

    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(UsersPermission::class);
    }
}
