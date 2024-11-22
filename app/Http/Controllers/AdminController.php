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
    try {

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

        // Jika berhasil, kirimkan flash session dan arahkan
        return redirect('/users')->with('success', 'User telah di tambahkan!');
    } catch (\Exception $e) {
        // Jika terjadi kesalahan, kirimkan flash session error
        return redirect('/users')->with('error', 'User gagal di tambahkan, silahkan ulangi lagi.');
    }
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




    public function deleteuser(Request $request){
        User::where('id', $request->id)->delete();
        return redirect('/users')->with('success',);
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

        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed', // Password optional
            'role' => 'required|in:admin,student,assessor',
            'nisn' => 'nullable|string|max:20', // Untuk student
            'grade_level' => 'nullable|in:10,11,12',
            'major_id' => 'nullable|exists:majors,id',
            'assessor_type' => 'nullable|in:internal,external', // Untuk assessor
            'description' => 'nullable|string|max:1000',
        ]);

        // Update data umum
        $user->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            // Hanya ubah password jika diisi
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Update data student (jika role student)
        if ($request->role === 'student') {
            $user->student()->update( [
                'nisn' => $request->nisn,
                'grade_level' => $request->grade_level,
                'major_id' => $request->major_id,
            ]);
        }

        // Update data assessor (jika role assessor)
        if ($request->role === 'assessor') {
            $user->assessor()->update( [
                'assessor_type' => $request->assessor_type,
                'description' => $request->description,
            ]);
        }

        return redirect('/users')->with('success', 'User updated successfully!');
    }

    //majors
    public function majors(){
        $majors['majors'] = Major::all();
        return view('admin/majors/majors',$majors,);
    }
    public function addmajors(Request $request)
    {
        try {
            // Tambahkan data ke database
            Major::create([
                'major_name' => $request->major_name,
                'description' => $request->description
            ]);

            // Redirect dengan session 'success'
            return redirect('/majors')->with('success', 'Major successfully added!');
        } catch (\Exception $e) {
            // Redirect dengan session 'error' jika terjadi error
            return redirect('/majors')->with('error', 'Failed to add major.');
        }
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

