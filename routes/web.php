<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function(){
    $nama = "Eko";
    $umur = 28;
    // return view('about', ['nama' => $nama, 'umur' => 28]);
    // return view('about', compact('nama', 'umur'));
    return view('about')
                ->with('nama', 'Eko Apriliyani')
                ->with('umur', 36);
});

Route::get('/contact', function(){
    return view('contact');
});

Route::get('/siswa', [SiswaController::class, 'index']);

Route::get('/siswa/{id}', [SiswaController::class, 'show']);