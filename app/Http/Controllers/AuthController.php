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
            return view('student.profile.profilestudent', compact('user', 'student'))->with('role', 'student');
        }
    }
    public function editprofile($id)
    {
        $authUser = Auth::user();
        $role = $authUser->role;
        $user = User::findOrFail($id);
        if ($role == 'admin') {
            $user = User::find($authUser->id);
            return view('admin.profile.editprofile', compact('user'))->with('role', 'admin');
        } elseif ($role == 'assessor') {
            $user = User::find($authUser->id);
            $assessor = Assessor::where('user_id', $authUser->id)->first();
            return view('assessor.profile.editprofile', compact('user', 'assessor'))->with('role', 'assessor');
        } elseif ($role == 'student') {
            $user = User::find($authUser->id);
            $student = Student::where('user_id', $authUser->id)->first();
            return view('student.profile.editprofilest', compact('user', 'student'))->with('role', 'student');
        }
        // return view('assessor.profile.editprofile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Update data umum
        $user->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            // Hanya ubah password jika diisi
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect('/profile/admin')->with('success', 'Profil berhasil diperbarui!');
            case 'assessor':
                return redirect('/profile/assessor')->with('success', 'Profil berhasil diperbarui!');
            case 'student':
                return redirect('/profile/student')->with('success', 'Profil berhasil diperbarui!');
            default:
                return redirect('/')->with('error', 'Role tidak dikenali.');
        }
    }

}
