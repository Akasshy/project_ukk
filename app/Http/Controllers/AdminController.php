<?php

namespace App\Http\Controllers;

use App\Models\Assessor;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users(){
        $users['users'] = User::all();
        return view('admin/users/users',$users,);
    }

    public function adduser(Request $request)
    {
        // $validatedData = $request->validate([
        //     'full_name' => 'required|string|max:64',
        //     'username' => 'required|string|max:64|unique:users',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|string|min:6',
        //     'role' => 'required|in:student,assessor',
        //     // Validasi tambahan untuk student
        //     'nisn' => 'nullable|required_if:role,student|digits:10|unique:students',
        //     'grade_level' => 'nullable|required_if:role,student|integer|min:1',
        //     'major_id' => 'nullable|required_if:role,student|exists:majors,id',
        //     // Validasi tambahan untuk assessor
        //     'assessor_type' => 'nullable|required_if:role,assessor|in:internal,external',
        //     'description' => 'nullable|required_if:role,assessor|string',
        // ]);

        // Buat user
        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'is_active' => 1,
        ]);

        // Tambahkan data ke tabel terkait
        if ($user->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'grade_level' => $request->grade_level,
                'major_id' => $request->major_id,
            ]);
        } elseif ($user->role === 'assessor') {
            Assessor::create([
                'user_id' => $user->id,
                'assessor_type' => $request->assessor_type,
                'description' => $request->description,
            ]);
        }

        return redirect('/users')->with('success', 'User added successfully!');
    }

    public function viewadduser(){
        $majors['majors'] = Major::all();
        return view('admin/users/adduser',$majors,);
    }
    public function admin(){
        $users['users'] = User::where('role', 'admin')->get();
        return view('admin/users/admin',$users,);
    }

    public function assesor(){
        $users['users'] = Assessor::all();
        // $users['users'] = User::all();
        return view('admin/users/assessor',$users,);
    }
    public function student(){
        $users['users'] = Student::all();
        return view('admin/users/student',$users,);
    }

    public function fullname(){
        $userName = Auth::user()->full_name;
        return view('template/template', compact('username'));
    }

    public function majors(){
        $majors['majors'] = Major::all();
        return view('admin/majors/majors',$majors,);
    }
    public function viewaddmajors(){
        return view('admin/majors/addmajors');
    }
    public function addmajors(Request $request){
        Major::create([
            'major_name' => $request->major_name,
            'description' => $request->description
        ]);
        return redirect('/majors')->with('success','');
    }
}
