<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPilihanKualitatifController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonitoringAllController;
use App\Http\Controllers\TitikPengamatanController;
use App\Http\Controllers\KategoriParameterController;
use App\Http\Controllers\MonitoringPerZonaController;
use App\Http\Controllers\MonitoringPerTitikController;
use App\Http\Controllers\MonitoringPerKategoriController;
use App\Http\Controllers\UbahUrutanTitikPengamatanController;

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
Route::resource('/jenis_pilihan_kualitatif', JenisPilihanKualitatifController::class)->middleware(['auth']);
Route::resource('/titik_pengamatan', TitikPengamatanController::class)->middleware(['auth']);
Route::resource('/role', RoleController::class)->middleware(['auth']);
Route::resource('/user', UserController::class)->middleware(['auth']);
Route::resource('/monitoring', MonitoringController::class)->middleware(['auth']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login_process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/change_session_periode', [AuthController::class, 'changeSessionPeriode'])->name('change_session_periode');
Route::get('/ubah_urutan_titik_pengamatan', [UbahUrutanTitikPengamatanController::class, 'index'])->name('ubah_urutan_titik_pengamatan.index')->middleware(['auth']);
Route::post('/ubah_urutan_titik_pengamatan', [UbahUrutanTitikPengamatanController::class, 'process'])->name('ubah_urutan_titik_pengamatan.process')->middleware(['auth']);
Route::get('/monitoring_per_kategori/{kategori_parameter_id}', [MonitoringPerKategoriController::class, 'index'])->name('monitoring_per_kategori.index')->middleware(['auth']);
Route::get('/monitoring_per_kategori/data/{kategori_parameter_id}', [MonitoringPerKategoriController::class, 'data'])->name('monitoring_per_kategori.data');
Route::get('/monitoring_per_zona/{zona_parameter_id}', [MonitoringPerZonaController::class, 'index'])->name('monitoring_per_zona.index')->middleware(['auth']);
Route::get('/monitoring_per_zona/data/{zona_parameter_id}', [MonitoringPerZonaController::class, 'data'])->name('monitoring_per_zona.data');
Route::get('/monitoring_all', [MonitoringAllController::class, 'index'])->name('monitoring_all')->middleware(['auth']);
Route::get('/monitoring_per_titik/{titik_pengamatan_id}', [MonitoringPerTitikController::class, 'index'])->name('monitoring_per_titik.index')->middleware(['auth']);
Route::get('/monitoring_per_titik/data/{titik_pengamatan_id}', [MonitoringPerTitikController::class, 'data'])->name('monitoring_per_titik.data');
