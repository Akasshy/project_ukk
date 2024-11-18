<?php

use App\Http\Controllers\AdminController;
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
    return view('login2');
});
Route::get('/dasboard', function () {
    return view('admin/admin-dasboard');
});
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

Route::get('/majors',[AdminController::class,'majors']);
Route::get('/vaddmj',[AdminController::class,'viewaddmajors']);
Route::post('/add/majors',[AdminController::class,'addmajors']);

Route::get('/logout',[AuthController::class,'logout']);
