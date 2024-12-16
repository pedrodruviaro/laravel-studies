<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController
{
    public function login()
    {
        return view('login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'text_username' => ['required'],
            'text_password' => ['required'],
        ]);

        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if user exists
        $user = User::where('username', $username)->where('deleted_at', NULL)->first();

        if(!$user) {
            return redirect()->back()->withInput()->with('login_error', 'Incorrect username or password');
        }

        // check if password is correct
        if(!password_verify($password, $user->password)){ 
            return redirect()->back()->withInput()->with('login_error', 'Incorrect username or password');
        }

        // update last login column
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // redirect
        return redirect('/');
    }

    public function logout()
    {
        // logout from app
        session()->forget('user');
        return redirect()->to('/login');
    }
}
