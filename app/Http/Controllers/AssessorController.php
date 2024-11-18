<?php

namespace App\Http\Controllers;


use App\Models\CompetencyStandar;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessorController extends Controller
{

    public function standars(){
        $standars = CompetencyStandar::all();
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
        return redirect('/standars')->with('success','');
    }
}
