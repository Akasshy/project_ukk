<?php

namespace App\Http\Controllers;

use App\Models\CompetencyStandar;
use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class StudentController extends Controller
{
    public function dasboard(){
        return view('student.dasboardst');
    }
    public function report(Request $request)
    {
        // Ambil ID student dari user yang sedang login
        $student = Auth::user()->student; // Pastikan relasi 'student' didefinisikan di model User

        if (!$student) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Ambil major_id dari student
        $major_id = $student->major_id;

        // Ambil daftar standar kompetensi terkait major student
        $standars = CompetencyStandar::with('major') // Pastikan relasi 'major' ada di model CompetencyStandar
            ->where('major_id', $major_id)
            ->get();

        // Ambil standar_id dari request, atau gunakan default 1 jika kosong
        $standar_id = $request->input('standar_id', 1); // Default ke 1 jika tidak ada input

        // Validasi standar ID
        $standard = CompetencyStandar::where('id', $standar_id)->with('competency_elements')->first();

        if (!$standard) {
            return back()->with('error', 'Standar kompetensi tidak ditemukan.');
        }

        // Mendapatkan data ujian untuk student yang sedang login
        $examinations = Examination::where('standar_id', $standar_id)
            ->where('student_id', $student->id) // Filter berdasarkan ID student yang login
            ->with('student.user')
            ->get();

        // Hitung skor berdasarkan data ujian
        $totalElements = $standard->competency_elements->count();
        $completedElements = $examinations->where('status', 1)->unique('element_id')->count();
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

        // Struktur data untuk view
        $studentReport = [
            'student_id' => $student->id,
            'student_name' => $student->user->full_name,
            'final_score' => $finalScore,
            'status' => $status,
        ];

        // Mengirim data ke view
        return view('student.hasilujianst', compact('standard', 'studentReport', 'standars', 'standar_id'));
    }


    public function getReport(Request $request)
    {
        // Ambil ID standar kompetensi dari request
        $standar_id = $request->input('standar_id');

        // Ambil student ID dari user yang login
        $student = Auth::user()->student; // Pastikan relasi 'student' didefinisikan di model User
        if (!$student) {
            return response()->json(['error' => 'Data mahasiswa tidak ditemukan.'], 404);
        }

        // Validasi apakah standar kompetensi ada
        $standard = CompetencyStandar::where('id', $standar_id)->with('competency_elements')->first();
        if (!$standard) {
            return response()->json(['error' => 'Standar kompetensi tidak ditemukan.'], 404);
        }

        // Ambil data ujian untuk student login berdasarkan standar_id
        $examinations = Examination::where('standar_id', $standar_id)
            ->where('student_id', $student->id) // Filter berdasarkan student login
            ->get();

        // Hitung skor berdasarkan data ujian
        $totalElements = $standard->competency_elements->count();
        $completedElements = $examinations->where('status', 1)->unique('element_id')->count();
        $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;

        // Tentukan status kompetensi
        if ($finalScore >= 91) {
            $status = "Sangat Kompeten";
        } elseif ($finalScore >= 75 && $finalScore <= 90) {
            $status = "Kompeten";
        } elseif ($finalScore >= 61 && $finalScore <= 74) {
            $status = "Cukup Kompeten";
        } else {
            $status = "Belum Kompeten";
        }

        // Struktur data untuk response
        $studentReport = [
            'student_id' => $student->id,
            'student_name' => $student->user->full_name,
            'final_score' => $finalScore,
            'status' => $status,
        ];

        // Respons ke DataTables
        return response()->json([
            'data' => [$studentReport], // Data dijadikan array untuk konsistensi
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
    public function generatePDF(Request $request)
    {
        $standar_id = $request->input('standar_id');
        $logged_in_student_id = Auth::user()->student->id; // Ambil ID siswa dari user yang login

        // Validasi apakah standar kompetensi ada
        $standard = CompetencyStandar::where('id', $standar_id)->with('competency_elements')->first();
        if (!$standard) {
            return redirect()->back()->with('error', 'Standar kompetensi tidak ditemukan.');
        }

        // Ambil data ujian berdasarkan standar_id dan ID siswa yang login
        $examinations = Examination::where('standar_id', $standar_id)
            ->where('student_id', $logged_in_student_id)
            ->with(['student.user', 'elements'])
            ->get();

        // Jika data kosong
        if ($examinations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data hasil ujian untuk siswa yang sedang login.');
        }

        // Proses data siswa
        $students = $examinations->groupBy('student_id')->map(function ($exams) use ($standard) {
            $totalElements = $standard->competency_elements->count();
            $completedElements = $exams->where('status', 1)->unique('element_id')->count();

            $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;

            $status = match (true) {
                $finalScore >= 91 => "Sangat Kompeten",
                $finalScore >= 75 && $finalScore <= 90 => "Kompeten",
                $finalScore >= 61 && $finalScore <= 74 => "Cukup Kompeten",
                default => "Belum Kompeten",
            };

            $examElements = $exams->map(function ($exam) {
                return [
                    'criteria' => $exam->element->criteria,
                    'status' => $exam->status == 1 ? 'Kompeten' : 'Belum Kompeten',
                ];
            });

            return [
                'student_name' => $exams->first()->student->user->full_name,
                'final_score' => $finalScore,
                'status' => $status,
                'elements' => $examElements,
            ];
        });

        // Generate PDF
        $pdf = Pdf::loadView('student/sertificate', ['students' => $students, 'standard' => $standard]);
        return $pdf->stream('HasilUjian.pdf');
    }


}
