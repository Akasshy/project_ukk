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
    // Validasi input
    $validatedData = $request->validate([
        'login' => ['required'], // Bisa berupa email atau username
        'password' => ['required'],
    ]);

    // Tentukan apakah input login adalah email atau username
    $loginType = filter_var($validatedData['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Autentikasi berdasarkan loginType
    $credentials = [
        $loginType => $validatedData['login'],
        'password' => $validatedData['password'],
    ];

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Cek apakah user aktif
        if ($user->is_active == 0) {
            // Jika tidak aktif, logout dan tampilkan pesan
            Auth::logout();
            session()->flash('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            return redirect()->back();
        }

        session(['user_name' => $user->full_name]);

        // Simpan pesan berhasil ke session
        session()->flash('success', 'Login berhasil! Selamat datang, ' . $user->full_name);

        // Redirect berdasarkan role pengguna
        if ($user->role == 'admin') {
            return redirect('/dasboard');
        } elseif ($user->role == 'assessor') {
            return redirect('/dasboard/as');
        } else {
            return redirect('/hasil/ujian/siswa');
        }
    }

    // Jika login gagal, simpan pesan gagal ke session
    session()->flash('error', 'Username/Email atau Password salah. Silakan coba lagi.');

    return redirect()->back();
}


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate(); // Menghancurkan sesi
        $request->session()->regenerateToken();
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
