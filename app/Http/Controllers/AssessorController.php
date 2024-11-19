<?php

namespace App\Http\Controllers;

use App\Models\CompetencyElement;
use App\Models\CompetencyStandar;
use App\Models\Major;
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

    public function elements(Request $request)
    {
        $id = Auth::user()->assessor->id;

        $standars = CompetencyStandar::with('elements')
            ->where('assessor_id', $id)
            ->get();

        return view('assessor.element.elementskom', compact('standars'));
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
        return redirect('/standars')->with('success','');
    }

    public function deletest(Request $request){
        CompetencyStandar::where('id',$request->id)->delete();
        return redirect('/standars')->with('sucses');
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
        return redirect('/standars')->with('success', 'Competency Standard updated successfully!');
    }

    public function addelement(Request $request)
    {
        $request->validate([
            'criteria' => 'required|string|max:255', // Tambahkan batas panjang untuk keamanan
            'competency_id' => 'required|exists:competency_standars,id', // Pastikan tabel dan kolom benar
        ]);

        // Simpan elemen baru
        CompetencyElement::create([
            'criteria' => $request->criteria,
            'competency_id' => $request->competency_id,
        ]);

        return redirect()->back()->with('success', 'Element added successfully.');
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

        return redirect()->back()->with('success', 'Element updated successfully.');
    }
    public function deleteele($id)
    {
        try {
            // Cari element berdasarkan ID
            $element = CompetencyElement::findOrFail($id);

            // Hapus elemen
            $element->delete();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Element deleted successfully.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika terjadi masalah
            return redirect()->back()->with('error', 'Failed to delete the element. Please try again.');
        }
    }

}
