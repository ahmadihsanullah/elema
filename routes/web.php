<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/template-siswa', function () {
    $filePath = storage_path('app/public/panduan/template-siswa.xlsx'); // Pastikan file ada di lokasi yang tepat

    return Response::download($filePath);
})->name('template-siswa');

Route::get('/template-guru', function () {
    $filePath = storage_path('app/public/panduan/template-guru.xlsx'); // Pastikan file ada di lokasi yang tepat

    return Response::download($filePath);
})->name('template-guru');

Route::get('/template-soal', function () {
    $filePath = storage_path('app/public/panduan/template-soal.xlsx'); // Pastikan file ada di lokasi yang tepat

    return Response::download($filePath);
})->name('template-soal');