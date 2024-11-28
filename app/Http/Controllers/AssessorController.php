<?php

namespace App\Http\Controllers;

use App\Models\CompetencyElement;
use App\Models\CompetencyStandar;
use App\Models\Examination;
use App\Models\Major;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessorController extends Controller
{

    public function dasboard()
    {
        $id = Auth::user()->assessor->id;  // Mendapatkan ID assessor dari pengguna yang sedang login

        // Ambil kompetensi standar yang terkait dengan assessor
        $idst = CompetencyStandar::where('assessor_id', $id)->get();

        // Hitung jumlah kompetensi standar
        $st = $idst->count();

        // Jika ada kompetensi standar, ambil ID dari kompetensi standar pertama
        $idstc = $idst->first()->id ?? null;  // Menggunakan null jika tidak ada kompetensi standar

        // Ambil competency elements berdasarkan kompetensi standar yang ditemukan
        $el = 0; // Defaultkan elemen ke 0 jika tidak ada kompetensi standar
        if ($idstc) {
            $idel = CompetencyElement::where('competency_id', $idstc)->get();
            $el = $idel->count();
        }

        // Kembalikan ke view dengan data yang dibutuhkan
        return view('assessor.assessor-dasboard', compact('st', 'el'));
    }

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

    public function detailsStandar(Request $request, $id)
    {
        // Cari data CompetencyStandar berdasarkan ID
        $competencyStandar = CompetencyStandar::findOrFail($id);

        // Ambil data elemen kompetensi yang sesuai dengan competency_id
        $standars = CompetencyElement::where('competency_id', $competencyStandar->id)->get();

        // Ambil nama atau unit title untuk ditampilkan
        $id_st = $competencyStandar->id;
        $name = $competencyStandar->unit_title;

        // Kirim data ke view
        return view('assessor.standar.detailstandar', compact('standars', 'id_st', 'name'));
    }


    public function vaddelement($id){

        $competency_id = CompetencyStandar::find($id)->id;
        // $competency_id = $id;

        return view('assessor.standar.addelement',compact('competency_id',));
    }
    public function addelement(Request $request, $competency_id)
    {
        // Validasi data input
        $request->validate([
            'criteria.*' => 'required|string|max:255',
        ]);

        foreach ($request->criteria as $criteria) {
            CompetencyElement::create([
                'competency_id' => $competency_id,
                'criteria' => $criteria,
            ]);
        }
        session()->flash('success', 'Element berhasil ditambahkan.');

        // Redirect kembali
        return redirect()->back();
    }
    public function editelement($id)
    {
        $element = CompetencyElement::findOrFail($id);
        $standards = CompetencyStandar::all(); // Ambil semua standar kompetensi
        return view('assessor.standar.editelement', compact('element', 'standards'));
    }

    public function updateElement(Request $request, $id)
    {
        // $request->validate([
        //     'criteria' => 'required|string|max:255',
        //     'competency_id' => 'required|exists:competency_standars,id',
        // ]);

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



    public function dtPenilaian($id)
    {
        $standars = CompetencyStandar::find($id);
        $students = Student::where('major_id', $standars->major_id)->get();
        $standar_id = CompetencyStandar::where('id', $id)->first();
        $element = CompetencyElement::where('competency_id', $standar_id->id)->get();

        // Ambil data examination yang sesuai dan grupkan berdasarkan student_id
        $examinations = Examination::where('standar_id', $id)->get()->groupBy('student_id');

        return view('assessor.penilaian.menilai', compact('element', 'standar_id', 'students', 'examinations'));
    }


    public function addOrUpdateExamination(Request $request, $id)
    {
        $student_id = $request->input('student_id');
        $statuses = $request->input('status');
        $id_as = Auth::user()->assessor->id;
        $standar = CompetencyStandar::find($id);

        if (!$student_id || !$standar) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        foreach ($statuses as $elementId => $status) {
            $examination = Examination::where([
                'student_id' => $student_id,
                'standar_id' => $standar->id,
                'element_id' => $elementId,
            ])->first();

            if ($examination) {
                // Update jika data sudah ada
                $examination->update(['status' => $status, 'comments' => 'Diperbarui']);
            } else {
                // Tambahkan data baru jika belum ada
                Examination::create([
                    'exam_date' => now(),
                    'student_id' => $student_id,
                    'assessor_id' => $id_as,
                    'standar_id' => $standar->id,
                    'element_id' => $elementId,
                    'status' => $status,
                    'comments' => 'Mantap',
                ]);
            }
        }

        session()->flash('success', 'Penilaian berhasil disimpan');
        return redirect()->back();
    }
    public function getExaminationData($standar_id, $student_id)
    {
        $standar = CompetencyStandar::find($standar_id);
        $element = CompetencyElement::where('competency_id', $standar->id)->get();

        // Ambil data examination berdasarkan student_id
        $examinations = Examination::where('standar_id', $standar_id)
            ->where('student_id', $student_id)
            ->get()
            ->keyBy('element_id')
            ->map(function ($exam) {
                return $exam->status; // Hanya kirimkan status
            });

        return response()->json([
            'elements' => $element,
            'examinations' => $examinations,
        ]);
    }


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
            // $status = $finalScore >= 90 ? 'Competent' : 'Not Competent';
            if ($finalScore >= 91) {
                $status = "Sangat Kompeten";
            }elseif ($finalScore >= 75 && $finalScore <= 90) {
                $status = "Kompeten";
            }elseif ($finalScore >= 61 && $finalScore <= 74) {
                $status = "Cukup Kompeten";
            }else{
                $status = "Belum Kompeten";

            }

            return [
                'student_id' => $exams->first()->student_id,
                'student_name' => $exams->first()->student->user->full_name,
                'final_score' => $finalScore,
                'status' => $status,
            ];
        });


        // Mengirim data ke view
        return view('assessor.laporan.hasilujian', compact('standard', 'students', 'standars'));
    }

    public function fetchResults(Request $request)
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
        $students = $examinations->groupBy('student_id')->map(function ($exams) use ($standard) {
            $totalElements = $standard->competency_elements->count();
            $completedElements = $exams->where('status', 1)->unique('element_id')->count();

            $finalScore = $totalElements > 0 ? round(($completedElements / $totalElements) * 100) : 0;
            // $status = $finalScore >= 90 ? 'Competent' : 'Not Competent';
            if ($finalScore >= 91) {
                $status = "Sangat Kompeten";
            }elseif ($finalScore >= 75 && $finalScore <= 90) {
                $status = "Kompeten";
            }elseif ($finalScore >= 61 && $finalScore <= 74) {
                $status = "Cukup Kompeten";
            }else{
                $status = "Belum Kompeten";

            }

            return [
                'student_id' => $exams->first()->student_id,
                'student_name' => $exams->first()->student->user->full_name,
                'final_score' => $finalScore,
                'status' => $status,
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


    public function report(Request $request)
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
        return view('assessor.laporan.laporanhasilujian', compact('standard', 'students', 'standars','standar_id'));
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

        return view('assessor.laporan.detaillaporan', compact('details'));
    }
    public function generatePDF(Request $request, $id)
    {
        $standar_id = $request->input('standar_id');
        $student_id = $id; // Get the student ID from the URL

        // Validate the competency standard
        $standard = CompetencyStandar::where('id', $standar_id)->with('competency_elements')->first();
        if (!$standard) {
            return redirect()->back()->with('error', 'Standar kompetensi tidak ditemukan.');
        }

        // Get exam data for the specific student and standard
        $examinations = Examination::where('standar_id', $standar_id)
            ->where('student_id', $student_id)
            ->with(['student.user', 'elements'])
            ->get();

        if ($examinations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data hasil ujian untuk siswa ini.');
        }

        // Process student exam results
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
        $pdf = Pdf::loadView('assessor/laporan/sertificateassessor', ['students' => $students, 'standard' => $standard]);
        return $pdf->stream('HasilUjian.pdf');
    }

}
