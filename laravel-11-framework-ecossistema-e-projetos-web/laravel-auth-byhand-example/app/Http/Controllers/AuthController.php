<?php

namespace App\Http\Controllers;

use App\Mail\NewUserConfirmation;
use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        // validate request
        $credentials = $request->validate(
            [
                'username' => ['required', 'min:3', 'max:30'],
                'password' => ['required', 'min:8', 'max:32', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ],
            [
                'username.required' => 'O campo usuário é obrigatório',
                'username.min' => 'O campo deve conter no mínimo :min caracteres',
                'username.max' => 'O campo deve conter no máximo :max caracteres',
                'password.required' => 'O campo de senha é obrigatório',
                'password.min' => 'O campo deve conter no mínimo :min caracteres',
                'password.max' => 'O campo deve conter no máximo :max caracteres',
                'password.regex' => 'O campo deve conter pelo menos uma letra minúscula, uma letra maiúscula e um número',
            ]
        );

        /* ---- traditional Laravel login ---- */
        // attempt ONLY uses email and password
        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->route('home');
        // }

        // verify if user exists and user is active and is not blocked and email is verified and is not deleted
        $user = User::where('username', $credentials['username'])
            ->where('active', true)
            ->where(function ($query) {
                $query->whereNull('blocked_until')->orWhere('blocked_until', '<=', now());
            })
            ->whereNotNull('email_verified_at')
            ->whereNull('deleted_at')
            ->first();

        if (!$user) {
            return back()->withInput()->with([
                'invalid_login' => 'Login Inválido'
            ]);
        }

        // verify is password matches the stored user (raw php)
        if (!password_verify($credentials['password'], $user->password)) {
            return back()->withInput()->with([
                'invalid_login' => 'Login Inválido2'
            ]);
        }

        // update last_login and blocked columns 
        $user->last_login_at = now();
        $user->blocked_until = null;
        $user->save();

        // login 
        $request->session()->regenerate();
        Auth::login($user);

        // redirect
        // return redirect()->route('home');
        return redirect()->intended(route('home')); // redirect to page that the user tried to acess. if not, goes back home
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function store_user(Request $request): RedirectResponse | View
    {
        $request->validate(
            [
                'username' => ['required', 'min:3', 'max:30', 'unique:users'], // same as 'unique:users,username'
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8', 'max:32', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'password_confirmation' => ['required', 'same:password'],
            ],
            [
                'username.required' => 'O campo usuário é obrigatório',
                'username.min' => 'O campo deve conter no mínimo :min caracteres',
                'username.max' => 'O campo deve conter no máximo :max caracteres',
                'username.unique' => 'Este usuário já está em uso',
                'email.required' => 'O campo de email é obrigatório',
                'email.email' => 'O email informado é inválido',
                'email.unique' => 'Este email já está em uso',
                'password.required' => 'O campo de senha é obrigatório',
                'password.min' => 'O campo deve conter no mínimo :min caracteres',
                'password.max' => 'O campo deve conter no máximo :max caracteres',
                'password.regex' => 'O campo deve conter pelo menos uma letra minúscula, uma letra maiúscula e um número',
                'password_confirmation.required' => 'O campo de confirmação de senha é obrigatório',
                'password_confirmation.same' => 'As senhas devem ser iguais',
            ]
        );

        // create new user with email verification token
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->token = Str::random(64); // 64 chars

        // https://laravel.com/docs/11.x/mail#generating-mailables

        // generate link
        $confirmation_link = route('new_user_confirmation', ['token' => $user->token]);

        // send email
        $result = Mail::to($user->email)->send(new NewUserConfirmation($user->username, $confirmation_link));

        // check if the email was send
        if (!$result) {
            return back()->withInput()->with([
                'server_error' => 'Ocorreu um erro ao enviar o email de confirmação'
            ]);
        }

        // all good! create user
        $user->save();

        // success view
        return view("auth.email_sent", ['email' => $user->email]);
    }

    public function new_user_confirmation(string $token): RedirectResponse | View
    {
        // check if token is valid
        $user = User::where('token', $token)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        // confirm register
        $user->email_verified_at = Carbon::now();
        $user->token = null;
        $user->active = true;
        $user->save();

        // auth user and show success
        Auth::login($user);

        return view('auth.new_user_confirmation');
    }


    public function profile(): View
    {
        return view('auth.profile');
    }

    public function change_password(Request $request)
    {
        $request->validate(
            [
                'current_password' => ['required', 'min:8', 'max:32', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'new_password' => ['required', 'min:8', 'max:32', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'different:current_password'],
                'new_password_confirmation' => ['required', 'same:new_password'],
            ],
            [
                'current_password.required' => 'O campo de senha atual é obrigatório',
                'current_password.min' => 'O campo deve conter no mínimo :min caracteres',
                'current_password.max' => 'O campo deve conter no máximo :max caracteres',
                'current_password.regex' => 'O campo deve conter pelo menos uma letra minúscula, uma letra maiúscula e um número',
                'new_password.required' => 'O campo de nova senha é obrigatório',
                'new_password.min' => 'O campo deve conter no mínimo :min caracteres',
                'new_password.max' => 'O campo deve conter no máximo :max caracteres',
                'new_password.regex' => 'O campo deve conter pelo menos uma letra minúscula, uma letra maiúscula e um número',
                'new_password.different' => 'A nova senha deve ser diferente da senha atual',
                'new_password_confirmation.required' => 'O campo de confirmação de nova senha é obrigatório',
                'new_password_confirmation.same' => 'As senhas devem ser iguais',
            ]
        );

        // check if passwords matches
        if (!password_verify($request->current_password, Auth::user()->password)) {
            return back()->with(['server_error' => 'A senha atual não está correta']);
        }

        // update user password on DB and session
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        Auth::user()->password = $request->new_password;

        // show success msg
        return redirect()->back()->with(['success' => 'Senha atualizada com sucesso!']);
    }

    public function forgot_password(): View
    {
        return view('auth.forgot_password');
    }


    public function send_reset_password_link(Request $request): RedirectResponse
    {
        // form validation
        $request->validate(
            [
                'email' => ['required', 'email'],
            ],
            [
                'email.required' => "Email é obrigatório",
                'email.email' => "Insira um email válido"
            ]
        );

        $GENERIC_MESSAGE = 'Verifique a sua caixa de correio para prosseguir com a recuperação de senha';

        // check if email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with([
                'server_message' => $GENERIC_MESSAGE
            ]);
        };

        // create link with token to send via email
        $user->token = Str::random(64);

        $token_link = route('reset_password', ['token' => $user->token]);

        // send email with link
        $result = Mail::to($user->email)->send(new ResetPassword($user->username, $token_link));

        // check if email was sent
        if (!$result) {
            return back()->with([
                'server_message' => $GENERIC_MESSAGE
            ]);
        }

        // save token to db
        $user->save();

        return back()->with([
            'server_message' => $GENERIC_MESSAGE
        ]);
    }

    public function reset_password(string $token): RedirectResponse | View
    {

        // check if token is valid
        $user = User::where('token', $token)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('auth.reset_password', ['token' => $token]);
    }

    public function reset_password_update(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'token' => ['required'],
                'new_password' => ['required', 'min:8', 'max:32', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'new_password_confirmation' => ['required', 'same:new_password'],
            ],
            [
                'new_password.required' => 'O campo de nova senha é obrigatório',
                'new_password.min' => 'O campo deve conter no mínimo :min caracteres',
                'new_password.max' => 'O campo deve conter no máximo :max caracteres',
                'new_password.regex' => 'O campo deve conter pelo menos uma letra minúscula, uma letra maiúscula e um número',
                'new_password_confirmation.required' => 'O campo de confirmação de nova senha é obrigatório',
                'new_password_confirmation.same' => 'As senhas devem ser iguais',
            ]
        );

        $user = User::where('token', $request->token)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        // update password on db
        $user->password = bcrypt($request->new_password);
        $user->token = null;
        $user->save();

        return redirect()->route('login')->with([
            'success' => true
        ]);
    }

    public function delete_account(Request $request): RedirectResponse
    {
        // validation
        $request->validate(
            [
                'delete_confirmation' => ['required', 'in:APAGAR']
            ],
            [
                'delete_confirmation.required' => 'A confirmação é obrigatória',
                'delete_confirmation.in' => 'Digite o texto "APAGAR" para remover a conta',
            ]
        );


        // remove
        // soft delete (use SoftDeletes)
        $user = Auth::user();
        $user->delete();

        // hard delete 
        // $user = Auth::user();
        // $user->forceDelete();

        // logout
        Auth::logout();

        // redirect
        return redirect()->route('login')->with(['success' => true]);
    }
}
