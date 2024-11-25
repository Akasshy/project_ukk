<?php

namespace App\Http\Controllers;

use App\Models\CompetencyStandar;
use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dasboard(){
        return view('student.dasboardst');
    }
    public function report(Request $request)
    {
        $id = Auth::user()->student->major_id; // Pastikan relasi 'assessor' didefinisikan di model User
        // Ambil daftar semua standar kompetensi terkait assessor
        $standars = CompetencyStandar::with('major') // Pastikan relasi 'major' ada di model CompetencyStandar
            ->where('major_id', $id)
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
        return view('student.hasilujianst', compact('standard', 'students', 'standars','standar_id'));
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

        return view('student.detailhasil', compact('details'));
    }

}
