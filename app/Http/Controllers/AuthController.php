<?php

namespace App\Http\Controllers;

use Filament\Panel\Concerns\HasAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        {{
            var_dump($credentials);
        }}
        if (Auth::guard('students')->attempt($credentials)) {
            $request->session()->regenerate();
            {{
                dd("halo");
            }}
            if (Auth::guard('siswa')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/siswa');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}
