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

    public function addmajors(Request $request){
        Major::create([
            'major_name' => $request->major_name,
            'description' => $request->description
        ]);
        return redirect('/majors')->with('success','');
    }

    public function deleteuser(Request $request){
        User::where('id', $request->id)->delete();
        return redirect('/users')->with('success','');
    }

    public function editUser($id)
    {
        $user = User::where('id',$id)->first();
        $majors = Major::all(); // Jika ada major untuk student
        return view('admin/users/edituser', compact('user', 'majors'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi umum
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:15',
            'role' => 'required|in:admin,student,assessor',
        ]);

        // Validasi tambahan berdasarkan role
        if ($request->role === 'student') {
            $request->validate([
                'nisn' => 'required|string|max:10|unique:students,nisn,' . ($user->student->id ?? null),
                'grade_level' => 'required|integer|in:10,11,12',
                'major_id' => 'required|exists:majors,id',
            ]);
        } elseif ($request->role === 'assessor') {
            $request->validate([
                'assessor_type' => 'required|in:internal,external',
                'description' => 'nullable|string|max:255',
            ]);
        }

        // Update data user
        $user->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
        ]);

        // Update data role-specific
        if ($request->role === 'student') {
            $user->student()->updateOrCreate([], [
                'nisn' => $request->nisn,
                'grade_level' => $request->grade_level,
                'major_id' => $request->major_id,
            ]);
        } elseif ($request->role === 'assessor') {
            $user->assessor()->updateOrCreate([], [
                'assessor_type' => $request->assessor_type,
                'description' => $request->description,
            ]);
        } else {
            // Hapus data role sebelumnya jika role tidak memerlukan data tambahan
            $user->student()->delete();
            $user->assessor()->delete();
        }

        return redirect('/users')->with('success', 'User updated successfully!');
    }

    //majors
    public function majors(){
        $majors['majors'] = Major::all();
        return view('admin/majors/majors',$majors,);
    }
    public function viewaddmajors(){
        return view('admin/majors/addmajors');
    }

    public function deletemj(Request $request){
        Major::where('id',$request->id)->delete();
        return redirect('/majors')->with('success','');
    }

    public function edit($id)
    {
        $major = Major::findOrFail($id);
        return view('admin/majors/editmajors', compact('major'));
    }

    // Update data major
    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);

        // Validasi data
        $request->validate([
            'major_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Update data
        $major->update([
            'major_name' => $request->major_name,
            'description' => $request->description,
        ]);

        return redirect('/majors')->with('success', 'Major updated successfully!');
    }
}
