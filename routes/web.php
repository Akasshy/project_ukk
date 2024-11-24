<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssessorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
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
Route::get('/dasboard/st', function () {
    return view('student.dasboardst');
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

//\


//Auth
Route::post('/login',[AuthController::class,'login']);
//Admin

//end amin

//ASSESOR

//student




Route::middleware(['role:admin'])->group(function () {
    Route::get('/profile/admin',[AuthController::class,'profile']);
    Route::get('/profile/edit/admin/{id}',[AuthController::class,'editprofile']);
    Route::get('/profile/update/admin/{id}',[AuthController::class,'editprofile']);

    Route::get('/dasboard',[AdminController::class,'dasboard']);
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

    //laporan
    Route::get('/hasil-ujian', [AdminController::class, 'report']);
    Route::get('/get-report', [AdminController::class, 'getReport']);
    Route::get('/detail/laporan/admin/{student_id}/{standar_id}',[AdminController::class,'detailLaporan']);
});

Route::middleware(['role:assessor'])->group(function () {

    Route::get('/dasboard/as',[AssessorController::class,'dasboard']);
    Route::get('/logout',[AuthController::class,'logout']);

    Route::get('/profile/assessor',[AuthController::class,'profile']);
    Route::get('/profile/edit/assessor/{id}',[AuthController::class,'editprofile']);
    Route::get('/profile/update/assessor/{id}',[AuthController::class,'editprofile']);

    //STANDAR
    Route::get('/standars',[AssessorController::class,'standars']);
    Route::get('/vaddst',[AssessorController::class,'vaddst']);
    Route::post('/addst',[AssessorController::class,'addst']);
    Route::get('/detail/standar/{id}',[AssessorController::class,'detailsStandar']);
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
    Route::get('/menilai/{id}', [AssessorController::class, 'dtPenilaian']);
    Route::post('/addExamination/{id}', [AssessorController::class, 'addOrUpdateExamination']);
    Route::get('/get-examination-data/{standar_id}/{student_id}', [AssessorController::class, 'getExaminationData']);

    //Laporan
    Route::get('/hasil/ujian',[AssessorController::class,'hasilUjian']);
    Route::get('/select/standar', [AssessorController::class, 'result']);
    Route::get('/get-results', [AssessorController::class, 'fetchResults']);

    Route::get('/laporan-hasil-ujian', [AssessorController::class, 'report']);
    Route::get('/get-report', [AssessorController::class, 'getReport']);
    Route::get('/detail/laporan/{student_id}/{standar_id}',[AssessorController::class,'detailLaporan']);

});

Route::middleware(['role:student'])->group(function () {
    Route::get('/profile/student',[AuthController::class,'profile']);
    Route::get('/profile/edit/assessor/{id}',[AuthController::class,'editprofile']);
    Route::get('/profile/update/assessor/{id}',[AuthController::class,'editprofile']);

    Route::get('/dasboard/st',[StudentController::class,'dasboard']);
    Route::get('/logout',[AuthController::class,'logout']);
    Route::get('/hasil/ujian/siswa', [StudentController::class, 'report']);
    Route::get('/get-resultst', [ StudentController::class, 'getReport']);
    Route::get('/detail/laporan/student/{student_id}/{standar_id}',[StudentController::class,'detailLaporan']);


});

