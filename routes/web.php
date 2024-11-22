<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessorController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/dasboard', function () {
    return view('admin/admin-dasboard');
});
Route::get('/dasboard/as', function () {
    return view('assessor/assessor-dasboard');
});
// Route::get('/tes', function () {
//     return view('assessor/standar/addstandar');
// });
// Route::get('/standar', function () {
//     return view('assessor/standar/standarkom');
// });
// Route::get('/coba', function () {
//     return view('admin/adduser');
// });

//


//Auth
Route::post('/login',[AuthController::class,'login']);

//Admin
Route::get('/users',[AdminController::class,'users']);
Route::get('/vaddus',[AdminController::class,'viewadduser']);
Route::get('/dtadmin',[AdminController::class,'admin']);
Route::get('/dtassesor',[AdminController::class,'assesor']);
Route::get('/dtstudent',[AdminController::class,'student']);
Route::post('/add/user',[AdminController::class,'adduser']);

Route::get('/veditus/{id}', [AdminController::class, 'editUser']);
Route::post('/user/{id}/update', [AdminController::class, 'updateUser']);
Route::get('/user/delete/{id}',[AdminController::class,'deleteuser']);

//majors
Route::get('/majors',[AdminController::class,'majors']);
Route::get('/vaddmj',[AdminController::class,'viewaddmajors']);
Route::post('/add/majors',[AdminController::class,'addmajors']);
Route::get('/majors/edit/{id}', [AdminController::class, 'edit']);
Route::get('/deletemj/{id}',[AdminController::class,'deletemj']);
Route::put('/majors/{id}/update', [AdminController::class, 'update']);
Route::get('/logout',[AuthController::class,'logout']);
//end amin

//ASSESOR
//STANDAR
Route::get('/standars',[AssessorController::class,'standars']);
Route::get('/vaddst',[AssessorController::class,'vaddst']);
Route::post('/addst',[AssessorController::class,'addst']);
// Route untuk edit competency standard
Route::get('/veditst/{id}', [AssessorController::class, 'edit']);
Route::post('/updatest/{id}', [AssessorController::class, 'update']);
Route::get('/delete/st/{id}',[AssessorController::class,'deletest']);
//ELEMENT
Route::get('/elements',[AssessorController::class,'elements']);
Route::post('/add/element',[AssessorController::class,'addelement']);

Route::put('/update/element/{id}', [AssessorController::class, 'updateElement'])->name('update.element');
Route::get('/delete/element/{id}', [AssessorController::class, 'deleteele']);

//PENILAIAN
Route::get('/penilaians',[AssessorController::class,'penilaian']);
Route::get('/select/siswa/{id}', [AssessorController::class, 'selectSiswa']);
Route::get('/menilai/{standar_id}/{id}', [AssessorController::class, 'dtPenilaian']);
Route::post('/add/examination/{student_id}/{standar_id}', [AssessorController::class, 'addExamination']);
//Laporan
Route::get('/hasil/ujian',[AssessorController::class,'hasilUjian']);
// Route::get('/select/standar',[AssessorController::class,'standarHj']);
// Route::get('/results/major/{majorId}', [AssessorController::class, 'getResultsByMajor'])->name('results.byMajor');
Route::get('/result/major', [AssessorController::class, 'result']);
Route::get('/select/standar', [AssessorController::class, 'result']);

// Route::get('/exam-result/{standard}', [AssessorController::class, 'fetchExamResult']);

// Route::get('/exam/report/competency-standard/{id}', [AssessorController::class, 'report']);
