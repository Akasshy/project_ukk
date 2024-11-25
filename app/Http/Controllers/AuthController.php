<?php

namespace App\Http\Controllers;

use App\Models\Assessor;
use App\Models\Student;
use App\Models\User;
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
            session(['user_name' => $user->full_name]); // Menyimpan nama pengguna di session

            if ($user->role == 'admin') {
                return redirect('/dasboard');
            } elseif ($user->role == 'assessor') {
                return redirect('/dasboard/as');
            } else {
                return redirect('/dasboard/st');
            }
        }

        return redirect()->back()->withErrors([
            'error' => 'Email atau password salah. Silakan coba lagi.',
        ]);
    }


    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function profile()
    {
        $authUser = Auth::user();
        $role = $authUser->role; // Mengambil role user yang sedang login

        if ($role == 'admin') {
            $user = User::find($authUser->id); // Hanya data user
            return view('admin.profile.profile', compact('user'))->with('role', 'admin');
        } elseif ($role == 'assessor') {
            $user = User::find($authUser->id);
            $assessor = Assessor::where('user_id', $authUser->id)->first();
            return view('assessor..profile.profile', compact('user', 'assessor'))->with('role', 'assessor');
        } elseif ($role == 'student') {
            $user = User::find($authUser->id);
            $student = Student::where('user_id', $authUser->id)->first();
            return view('profile', compact('user', 'student'))->with('role', 'student');
        }
    }
    public function editprofile($id)
    {
        $authUser = Auth::user();
        $role = $authUser->role; // Mengambil role user yang sedang login
        $user = User::findOrFail($id);
        if ($role == 'admin') {
            $user = User::find($authUser->id);
            return view('admin.profile.profile', compact('user'))->with('role', 'admin');
        } elseif ($role == 'assessor') {
            $user = User::find($authUser->id);
            $assessor = Assessor::where('user_id', $authUser->id)->first();
            return view('assessor..profile.profile', compact('user', 'assessor'))->with('role', 'assessor');
        } elseif ($role == 'student') {
            $user = User::find($authUser->id);
            $student = Student::where('user_id', $authUser->id)->first();
            return view('profile', compact('user', 'student'))->with('role', 'student');
        }
        return view('assessor.profile.editprofile', compact('user'));
    }
}
