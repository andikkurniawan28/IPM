<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriParameterController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TitikPengamatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZonaController;
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

Route::get('/', DashboardController::class)->name('dashboard')->middleware(['auth']);
Route::resource('/kategori_parameter', KategoriParameterController::class)->middleware(['auth']);
Route::resource('/satuan', SatuanController::class)->middleware(['auth']);
Route::resource('/zona', ZonaController::class)->middleware(['auth']);
Route::resource('/zona', ZonaController::class)->middleware(['auth']);
Route::resource('/parameter', ParameterController::class)->middleware(['auth']);
Route::resource('/titik_pengamatan', TitikPengamatanController::class)->middleware(['auth']);
Route::resource('/role', RoleController::class)->middleware(['auth']);
Route::resource('/user', UserController::class)->middleware(['auth']);
Route::resource('/monitoring', MonitoringController::class)->middleware(['auth']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login_process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/change_session_periode', [AuthController::class, 'changeSessionPeriode'])->name('change_session_periode');
