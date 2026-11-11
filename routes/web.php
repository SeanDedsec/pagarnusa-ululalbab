<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;

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