<?php

namespace App\Http\Controllers;

use App\Models\CompetencyElement;
use App\Models\CompetencyStandar;
use App\Models\Examination;
use App\Models\Major;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessorController extends Controller
{

    public function standars(Request $request)
    {
        $id = Auth::user()->assessor->id;
        $standars = CompetencyStandar::where('assessor_id', $id)->get();
        return view('assessor.standar.standarkom', compact('standars'));
    }

    public function vaddst(){
        $majors = Major::all();
        return view('assessor/standar/addstandar', compact('majors'));
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
            'assessor_id' => Auth::user()->assessor->id,
        ]);
        session()->flash('success', 'Data berhasil ditambahkan!');
        return redirect('/standars');
    }

    public function deletest(Request $request){
        CompetencyStandar::where('id',$request->id)->delete();
        session()->flash('success', 'Data berhasil dihapus!');
        return redirect('/standars');
    }

    public function edit($id)
    {
        // Ambil data competency standard berdasarkan ID
        $competencyStandard = CompetencyStandar::findOrFail($id);
        $majors = Major::all(); // Ambil daftar major

        // Tampilkan view edit dengan data competency standard dan majors
        return view('assessor/standar/editstandar', compact('competencyStandard', 'majors'));
    }

    public function update(Request $request, $id)
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

    public function elements(Request $request)
    {
        $id = Auth::user()->assessor->id;

        $standars = CompetencyStandar::with('elements')
            ->where('assessor_id', $id)
            ->get();

        return view('assessor.element.elementskom', compact('standars'));
    }
    // public function detail(Request $request)
    // {
    //     $id = Auth::user()->assessor->id;

    //     $standars = CompetencyStandar::with('elements')
    //         ->where('assessor_id', $id)
    //         ->get();

    //     return view('assessor.element.elementskom', compact('standars'));
    // }
    public function addelement(Request $request)
    {
        $request->validate([
            'criteria' => 'required|string|max:255',
            'competency_id' => 'required|exists:competency_standars,id',
        ]);

        // Simpan elemen baru
        CompetencyElement::create([
            'criteria' => $request->criteria,
            'competency_id' => $request->competency_id,
        ]);
        session()->flash('success', 'Elemen berhasil di tambahkan');

        return redirect()->back();
    }
    public function updateElement(Request $request, $id)
    {
        $request->validate([
            'criteria' => 'required|string|max:255',
            'competency_id' => 'required|exists:competency_standars,id',
        ]);

        $element = CompetencyElement::findOrFail($id);
        $element->update([
            'criteria' => $request->criteria,
            'competency_id' => $request->competency_id,
        ]);

        session()->flash('success', 'Elemen berhasil diperbarui!');
        // Setelah operasi delete
        return redirect()->back();
    }
    public function deleteele($id)
    {

        $element = CompetencyElement::findOrFail($id);
        $element->delete();

        return redirect()->back()->with('success', 'Element deleted successfully.');

    }

    public function penilaian(Request $request){
        $id = Auth::user()->assessor->id;
        $standars = CompetencyStandar::where('assessor_id', $id)->get();
        return view('assessor.penilaian.penilaian', compact('standars'));
    }

    public function selectSiswa($id){
        $standars = CompetencyStandar::find($id);
        $students = Student::where('major_id', $standars->major_id)->get();

        return view('assessor.penilaian.selectstudent', compact('standars', 'students'));
    }

    public function dtPenilaian( $standar_id , $id){
        $student_id = $id;
        $standar_id = CompetencyStandar::where('id',$standar_id)->first();
        $element = CompetencyElement::where('competency_id',$standar_id->id)->get();
        return view('assessor.penilaian.menilai',compact('element' ,'student_id','standar_id'));
    }
    public function addExamination(Request $request,$student_id)
    {
        // $standars = CompetencyStandar::find($standar_id);
        $st_id = $student_id;
        $statuses = $request->input('status');
        $id_as = Auth::user()->assessor->id;
        foreach ($statuses as $elementId => $status) {
            Examination::create([
                'exam_date' => now(),
                'student_id' => $st_id,
                'assessor_id' => $id_as,
                'standar_id' => $request->standar_id,
                'element_id' => $elementId,
                'status' => $status,
                'comments' => 'Mantap'
            ]);
        }

        session()->flash('success', 'Penilaian di tambahkan');
        return redirect()->back();
    }

    //laporan
    public function standarHj(Request $request)
{
    $id = Auth::user()->assessor->id; // Pastikan relasi 'assessor' didefinisikan di model User
    $standars = CompetencyStandar::with('major') // Pastikan relasi 'major' ada di model CompetencyStandar
        ->where('assessor_id', $id)
        ->get();

    return view('assessor.laporan.selectstandar', compact('standars'));
}

    // public function hasilUjian(Request $request){
    //     $id = Auth::user()->assessor->id;
    //     $hasil = Examination::where('assessor_id', $id)->get();
    //     return view('assessor.laporan.hasilujian',compact('hasil'));

    // }
    // public function getResultsByMajor($majorId)
    // {
    // // Ambil semua siswa berdasarkan major_id
    //     $students = Student::with(['user', 'major'])
    //         ->where('major_id', $majorId)
    //         ->get();

    //     $results = $students->map(function ($student) {
    //         $competencies = CompetencyStandar::where('major_id', $student->major_id)->get();

    //         $studentResults = $competencies->map(function ($competency) use ($student) {
    //             $totalElements = CompetencyElement::where('competency_id', $competency->id)->count();

    //             if ($totalElements == 0) {
    //                 return [
    //                     'competency_name' => $competency->unit_title,
    //                     'score' => 0,
    //                     'result' => 'No Elements',
    //                 ];
    //             }

    //             $correctExaminations = Examination::where('student_id', $student->id)
    //                 ->whereHas('element', function ($query) use ($competency) {
    //                     $query->where('competency_id', $competency->id);
    //                 })
    //                 ->where('status', 1)
    //                 ->count();

    //             $score = ($correctExaminations / $totalElements) * 100;
    //             $result = $score >= 90 ? 'Competent' : 'Not Competent';

    //             return [
    //                 'competency_name' => $competency->unit_title,
    //                 'score' => number_format($score, 2),
    //                 'result' => $result,
    //             ];
    //         });

    //         return [
    //             'nisn' => $student->nisn,
    //             'name' => $student->user->full_name,
    //             'major' => $student->major->major_name,
    //             'results' => $studentResults,
    //         ];
    //     });

    //     return view('assessor.laporan.hasilujian', compact('results'));
    // }

    // public function report(Request $request){
    //     $data['elements'] = CompetencyElement::where('competency_standard_id', $request->id)->get();
    //     $data['standard'] = CompetencyStandar::where('id', $request->id)->first();
    //     $data['active'] = 'examResultReport';
    //     $standard = CompetencyStandar::where('id', $request->id)->withCount('competency_elements')->first();
    //     // Mendapatkan data ujian murid berdasarkan standard yang dipilih
    //     $examinations = Examination::where('standard_id', $request->id)->get();
    //     $data['students'] = $examinations->groupBy('student_id')->map(function ($exams) use ($standard) {
    //         $totalElements = $standard->competency_elements_count;
    //         $completedElements = $exams->where('status', 1)->count(); // Menghitung elemen yang statusnya kompeten
    //         $finalScore = round(($completedElements / $totalElements) * 100);
    //         $status = $finalScore >= 75 ? 'Competent' : 'Not Competent';
    //         $elementsStatus = $standard->competency_elements->sortBy('code')->map(function ($element) use ($exams) {
    //             $exam = $exams->firstWhere('element_id', $element->id);
    //             return [
    //                 'status' => $exam ? ($exam->status == 1 ? 'Kompeten' : 'Belum Kompeten') : 'Belum Dinilai',
    //                 'comments' => $exam ? $exam->comments : '-'
    //             ];
    //         });

    //         return [
    //             'student_id' => $exams->first()->id,
    //             'student_name' => $exams->first()->student->user->full_name,
    //             'elements' => $elementsStatus,
    //             'final_score' => $finalScore,
    //             'status' => $status
    //         ];
    //     });

    //     // dd($data['students']);
    //     return view('assessor.examResultReportStudent', $data);
    // }
    // public function result(Request $request)
    // {
    // // Ambil standar kompetensi berdasarkan ID
    //     $standard = CompetencyStandar::with('competency_elements')->find($request->id);

    //     // Validasi jika standar kompetensi tidak ditemukan
    //     if (!$standard) {
    //         return redirect()->back()->with('error', 'Standar kompetensi tidak ditemukan.');
    //     }

    //     // Mendapatkan data ujian murid berdasarkan standar yang dipilih
    //     $examinations = Examination::where('element_id', $request->id)->get();

    //     // Validasi jika tidak ada data ujian
    //     if ($examinations->isEmpty()) {
    //         return redirect()->back()->with('error', 'Tidak ada data ujian untuk standar ini.');
    //     }

    //     $active = 'examResult';

    //     // Mendapatkan daftar murid yang mengikuti ujian pada standar kompetensi ini
    //     $students = $examinations->groupBy('student_id')->map(function ($exams) use ($standard) {
    //         // Hitung total elemen kompetensi
    //         $totalElements = $standard->competency_elements->count();

    //         // Hitung elemen kompeten secara unik berdasarkan element_id
    //         $completedElements = $exams->where('status', 1)->unique('element_id')->count();

    //         // Menghitung nilai akhir dalam bentuk persentase
    //         $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;

    //         // Menentukan status kompeten atau tidak kompeten
    //         $status = $finalScore >= 75 ? 'Competent' : 'Not Competent';

    //         return [
    //             'student_id' => $exams->first()->student_id,
    //             'student_name' => $exams->first()->student->user->full_name ?? 'Unknown',
    //             'final_score' => $finalScore,
    //             'status' => $status,
    //         ];
    //     });

    //     // Kirim data ke tampilan
    //     return view('assessor.laporan.hasilujian', [
    //         'standard' => $standard,
    //         'students' => $students,
    //         'active' => $active,
    //     ]);
    // }
    public function result(Request $request)
    {
        $id = Auth::user()->assessor->id; // Pastikan relasi 'assessor' didefinisikan di model User
        // Ambil daftar semua standar kompetensi terkait assessor
        $standars = CompetencyStandar::with('major') // Pastikan relasi 'major' ada di model CompetencyStandar
            ->where('assessor_id', $id)
            ->get();

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
        $students = $examinations->groupBy('student_id')->map(function ($exams) use ($standard) {
            $totalElements = $standard->competency_elements->count();
            $completedElements = $exams->where('status', 1)->unique('element_id')->count();

            $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;
            $status = $finalScore >= 90 ? 'Competent' : 'Not Competent';

            return [
                'student_id' => $exams->first()->student_id,
                'student_name' => $exams->first()->student->user->full_name,
                'final_score' => $finalScore,
                'status' => $status,
            ];
        });

        // Debug untuk melihat hasil
        // dd($students);

        // Mengirim data ke view
        return view('assessor.laporan.hasilujian', compact('standard', 'students', 'standars'));
    }

}
