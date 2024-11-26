<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        if(Auth::user()) return redirect('/');

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль',
        ]);
    }

    public function register(Request $request) {
        if(Auth::user()) return redirect()->back();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:4',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => 'img/avatar.png',
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
