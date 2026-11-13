<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Admin\ActivityController;

/*halaman public*/
Route::get('/', [HomeController::class, 'index']);

Route::get('/pendaftaran', function () {
    return view('site.registration');
});

Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('pendaftaran.store');

/*halaman admin*/
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin/dashboard', function () {
    return view('admin.pages.dashboard');
})->middleware('auth');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    });

    /* data siswa */
    Route::get('/siswa', [StudentController::class, 'index']);
    Route::post('/siswa', [StudentController::class, 'store']);
    Route::put('/siswa/{id}', [StudentController::class, 'update']);
    Route::delete('/siswa/{id}', [StudentController::class, 'destroy']);

    Route::get('/absensi', [AttendanceController::class, 'index']);
    Route::post('/absensi', [AttendanceController::class, 'store'])->name('absensi.store');

    Route::get('/keuangan', [TransactionController::class, 'index']);
    Route::post('/keuangan', [TransactionController::class, 'store']);
    Route::delete('/keuangan/{id}', [TransactionController::class, 'destroy']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/pelatih', [CoachController::class, 'index']);
    Route::post('/pelatih', [CoachController::class, 'store']);
    Route::put('/pelatih/{id}', [CoachController::class, 'update']);
    Route::delete('/pelatih/{id}', [CoachController::class, 'destroy']);

    Route::get('/kegiatan', [ActivityController::class, 'index']);
    Route::post('/kegiatan', [ActivityController::class, 'store']);
    Route::put('/kegiatan/{id}', [ActivityController::class, 'update']);
    Route::delete('/kegiatan/{id}', [ActivityController::class, 'destroy']);

});