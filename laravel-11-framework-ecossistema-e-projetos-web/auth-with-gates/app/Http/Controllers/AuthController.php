<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    public function loginAsAdmin(): RedirectResponse
    {
        $user = User::find(1);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function loginAsGuest(): RedirectResponse
    {
        $user = User::find(2);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function onlyAdmins()
    {
        if (Gate::allows('user_is_admin')) { // also possible: Auth::user()->can('user_is_admin')
            echo 'Welcome, admin!';
        } else {
            echo 'Not admin!!!!!!!!!!';
        }

        // we can use "->can('user_is_admin')" directly in the route
    }

    public function onlyGuests()
    {
        if (Gate::allows('user_is_guest')) {
            echo 'Welcome, guest!';
        } else {
            echo 'Not guest!!!!!!!!!!';
        }

        // also possible: Gate::denies('user_is_admin') 
        // also possible: Auth::user()->canot('user_is_admin')
    }
}
