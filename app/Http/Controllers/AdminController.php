<?php

namespace App\Http\Controllers;

use App\Models\Assessor;
use App\Models\CompetencyElement;
use App\Models\CompetencyStandar;
use App\Models\Examination;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dasboard(){
        return view('admin/admin-dasboard');
    }
    public function users(){
        $users['users'] = User::all();
        return view('admin/users/users',$users,);
    }

   public function adduser(Request $request){
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
        return redirect('/users')->with('success',)->with('success', 'Delete User Berhasil!');
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
            // 'role' => 'required|in:admin,student,assessor',
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
        return redirect('/majors')->with('success','')->with('success', 'Delete Major Berhasil!');
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

    public function standars(Request $request)
    {
        $standars = CompetencyStandar::all();
        return view('admin.competency.competencystandar', compact('standars'));
    }

    public function vaddst(){
        $assessor = Assessor::all();
        $majors = Major::all();
        return view('admin.competency.addstandar', compact('majors','assessor'));
    }
    public function addst(Request $request){
        $request->validate([
            'unit_code' => 'required|string|max:32',
            'unit_title' => 'required|string|max:64',
            'unit_description' => 'required|string',
            'major_id' => 'required|exists:majors,id',
        ]);
        CompetencyStandar::create([
            'unit_code' => $request->unit_code,
            'unit_title' => $request->unit_title,
            'unit_description' => $request->unit_description,
            'major_id' => $request->major_id,
            'assessor_id' => $request->assessor_id
        ]);
        session()->flash('success', 'Data berhasil ditambahkan!');
        return redirect('/admin/standars');
    }

    public function deletest(Request $request){
        CompetencyStandar::where('id',$request->id)->delete();
        session()->flash('success', 'Data berhasil dihapus!');
        return redirect('/admin/standars');
    }

    public function editst($id)
    {
        // Ambil data competency standard berdasarkan ID
        $competencyStandard = CompetencyStandar::findOrFail($id);
        $majors = Major::all(); // Ambil daftar major

        // Tampilkan view edit dengan data competency standard dan majors
        return view('assessor/standar/editstandar', compact('competencyStandard', 'majors'));
    }

    public function updatest(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'unit_code' => 'required|string|max:255',
            'unit_title' => 'required|string|max:255',
            'unit_description' => 'required|string',
            'major_id' => 'required|exists:majors,id',
        ]);

        // Update data competency standard
        $competencyStandard = CompetencyStandar::findOrFail($id);
        $competencyStandard->update([
            'unit_code' => $request->unit_code,
            'unit_title' => $request->unit_title,
            'unit_description' => $request->unit_description,
            'major_id' => $request->major_id,
        ]);

        // Redirect dengan pesan sukses
        session()->flash('success', 'Data berhasil diupdate!');
        return redirect('/standars');
    }

    public function detailsStandar(Request $request,$id)
    {
        $competencyStandar = CompetencyStandar::findOrFail($id);

        // Ambil data elemen kompetensi yang sesuai dengan competency_id
        $standars = CompetencyElement::where('competency_id', $competencyStandar->id)->get();

        // Ambil nama atau unit title untuk ditampilkan
        $id_st = $competencyStandar->id;
        $name = $competencyStandar->unit_title;

        // Kirim data ke view
        return view('admin.competency.detailcompetency', compact('standars', 'id_st', 'name'));
    }
    // public function elements(Request $request)
    // {
    //     $id = Auth::user()->assessor->id;

    //     $standars = CompetencyStandar::with('elements')
    //         ->where('assessor_id', $id)
    //         ->get();

    //     return view('assessor.element.elementskom', compact('standars'));
    // }

    // public function addelement(Request $request)
    // {
    //     $request->validate([
    //         'criteria' => 'required|string|max:255',
    //         'competency_id' => 'required|exists:competency_standars,id',
    //     ]);

    //     // Simpan elemen baru
    //     CompetencyElement::create([
    //         'criteria' => $request->criteria,
    //         'competency_id' => $request->competency_id,
    //     ]);
    //     session()->flash('success', 'Elemen berhasil di tambahkan');
    //     // dd($request->all());
    //     return redirect()->back();
    // }
    // public function updateElement(Request $request, $id)
    // {
    //     $request->validate([
    //         'criteria' => 'required|string|max:255',
    //         'competency_id' => 'required|exists:competency_standars,id',
    //     ]);

    //     $element = CompetencyElement::findOrFail($id);
    //     $element->update([
    //         'criteria' => $request->criteria,
    //         'competency_id' => $request->competency_id,
    //     ]);

    //     session()->flash('success', 'Elemen berhasil diperbarui!');
    //     // Setelah operasi delete
    //     return redirect()->back();
    // }
    // public function deleteele($id)
    // {

    //     $element = CompetencyElement::findOrFail($id);
    //     $element->delete();

    //     return redirect()->back()->with('success', 'Element deleted successfully.');

    // }
    public function report(Request $request)
    {
        // $id = Auth::user()->assessor->id; // Pastikan relasi 'assessor' didefinisikan di model User
        // Ambil daftar semua standar kompetensi terkait assessor
        $standars = CompetencyStandar::with('major')->get(); // Pastikan relasi 'major' ada di model CompetencyStandar

        // Ambil standar_id dari request, atau gunakan default 1 jika kosong
        $standar_id = $request->input('standar_id', 1); // Default ke 1 jika tidak ada input

        // Validasi standar ID
        $standard = CompetencyStandar::where('id', $standar_id)->with('competency_elements')->first();

        if (!$standard) {
            return back()->with('error', 'Standar kompetensi tidak ditemukan.');
        }

        // Mendapatkan data ujian berdasarkan standar yang dipilih
        $examinations = Examination::where('standar_id', $standar_id)->with('student.user')->get();

        // Kelompokkan berdasarkan student_id
        $students = $examinations->groupBy('student_id')->map(function ($exams) use ($standard, $standar_id) { // Tambahkan $standar_id di sini
            $totalElements = $standard->competency_elements->count();
            $completedElements = $exams->where('status', 1)->unique('element_id')->count();

            $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;

            if ($finalScore >= 91) {
                $status = "Sangat Kompeten";
            } elseif ($finalScore >= 75 && $finalScore <= 90) {
                $status = "Kompeten";
            } elseif ($finalScore >= 61 && $finalScore <= 74) {
                $status = "Cukup Kompeten";
            } else {
                $status = "Belum Kompeten";
            }

            return [
                'student_id' => $exams->first()->student_id,
                'student_name' => $exams->first()->student->user->full_name,
                'final_score' => $finalScore,
                'status' => $status,
                'action' => '',
                'standar_id' => $standar_id, // Tambahkan standar_id di sini
            ];
        });



        // Mengirim data ke view
        return view('admin.laporan.hasilujian', compact('standard', 'students', 'standars','standar_id'));
    }

    public function getReport(Request $request)
    {
        $standar_id = $request->input('standar_id');

        // Validasi apakah standar kompetensi ada
        $standard = CompetencyStandar::where('id', $standar_id)->with('competency_elements')->first();
        if (!$standard) {
            return response()->json(['error' => 'Standar kompetensi tidak ditemukan.'], 404);
        }

        // Ambil data ujian berdasarkan standar_id
        $examinations = Examination::where('standar_id', $standar_id)->with('student.user')->get();

        // Proses data siswa
        $students = $examinations->groupBy('student_id')->map(function ($exams) use ($standard, $standar_id) { // Tambahkan $standar_id di sini
            $totalElements = $standard->competency_elements->count();
            $completedElements = $exams->where('status', 1)->unique('element_id')->count();

            $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;

            if ($finalScore >= 91) {
                $status = "Sangat Kompeten";
            } elseif ($finalScore >= 75 && $finalScore <= 90) {
                $status = "Kompeten";
            } elseif ($finalScore >= 61 && $finalScore <= 74) {
                $status = "Cukup Kompeten";
            } else {
                $status = "Belum Kompeten";
            }

            return [
                'student_id' => $exams->first()->student_id,
                'student_name' => $exams->first()->student->user->full_name,
                'final_score' => $finalScore,
                'status' => $status,
                'action' => '',
                'standar_id' => $standar_id, // Tambahkan standar_id di sini
            ];
        });


        // Konversi ke array dan tambahkan indeks
        $studentsArray = $students->values()->map(function ($student, $index) {
            return array_merge(['DT_RowIndex' => $index + 1], $student);
        });

        // Respons ke DataTables
        return response()->json([
            'data' => $studentsArray,
        ]);
    }
    public function detailLaporan($student_id, $standar_id)
    {
        $details = Examination::with(['student.user', 'standar', 'elements'])
            ->where('student_id', $student_id)
            ->where('standar_id', $standar_id)
            ->get();

        if ($details->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.laporan.detailhasilujian', compact('details'));
    }

}

