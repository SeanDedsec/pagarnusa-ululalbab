<?php

use Illuminate\Support\Facades\Route;

// Halaman Beranda
Route::get('/', function () {
    return view('site.home'); // Titik berarti folder site, lalu file home
});

// Halaman Pendaftaran
Route::get('/pendaftaran', function () {
    return view('site.registration'); // Mengarah ke registration.blade.php
});