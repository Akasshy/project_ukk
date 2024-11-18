<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validatedData)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                $userName = Auth::user()->full_name;
                return redirect('/dasboard');
            } elseif ($user->role == 'assesor') {
                return redirect('/assesor-page');
            } else {
                return redirect('/student-page');
            }
        }

        return redirect()->back()->withErrors([
            'error' => 'Email atau password salah. Silakan coba lagi.',
        ]);
    }
    public function logout(Request $request){

        $request->session()->flush();
        Auth::logout();
        return redirect('/login');
    }

}