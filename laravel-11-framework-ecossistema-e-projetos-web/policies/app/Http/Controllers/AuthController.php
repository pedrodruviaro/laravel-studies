<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(int $id): RedirectResponse
    {
        // $user = User::find($id);
        // Auth::login($user);
        // return redirect()->route('home');

        $user = User::with('permissions')->find($id);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
