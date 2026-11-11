<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\RegistrationController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\Admin\StudentController;

/*halaman public*/
Route::get('/', function () {
    return view('site.home');
});

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
});