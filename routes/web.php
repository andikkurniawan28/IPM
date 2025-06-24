<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriParameterController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TitikPengamatanController;
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

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('/kategori_parameter', KategoriParameterController::class);
Route::resource('/satuan', SatuanController::class);
Route::resource('/zona', ZonaController::class);
Route::resource('/zona', ZonaController::class);
Route::resource('/parameter', ParameterController::class);
Route::resource('/titik_pengamatan', TitikPengamatanController::class);
