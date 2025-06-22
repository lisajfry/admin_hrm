<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\DinasLuarKotaController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('landing');
});



// Form login (GET)
Route::get('/login', function () {
    return view('login');
})->name('login');

// Proses login (POST)
Route::post('/login', function (Request $request) {
    return redirect()->route('admin.dashboard');
})->name('login.proses');

// Route untuk halaman register
Route::get('/register', function () {
    return view('register');
})->name('register');





Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');




Route::prefix('admin')->group(function () {
    Route::resource('karyawan', KaryawanController::class);
});

Route::resource('admin/jabatan', JabatanController::class)->names('jabatan');

Route::get('admin/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::get('admin/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
Route::put('admin/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
Route::delete('admin/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

Route::get('admin/absensi/create/masuk', [AbsensiController::class, 'formMasuk'])->name('absensi.masuk.create');
Route::post('admin/absensi/create/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk.store');

Route::get('admin/absensi/create/keluar', [AbsensiController::class, 'formKeluar'])->name('absensi.keluar.create');
Route::post('admin/absensi/create/keluar', [AbsensiController::class, 'absenKeluar'])->name('absensi.keluar.store');


Route::resource('admin/izin', IzinController::class)->names('izin');
Route::resource('admin/dinas', DinasLuarKotaController::class)->names('dinas');
Route::resource('lembur', LemburController::class)->names('lembur');;
Route::resource('task', TaskController::class);


Route::prefix('admin')->group(function () {
    Route::get('payroll', [PayrollController::class, 'getPayrollSummary'])->name('payroll.index');
});

Route::get('admin/payroll/slip', [PayrollController::class, 'generateSlipGaji'])->name('payroll.slip');
Route::get('admin/payroll/slip?id_karyawan={id}', [PayrollController::class, 'generateSlipGaji'])->name('payroll.slip');
Route::get('admin/payroll/export-excel', [PayrollController::class, 'exportExcel'])->name('payroll.exportExcel');


Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
