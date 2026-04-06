<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
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
})->name('about');

Route::get('/contact', function(){
    return view('contact');
})->name('contact');

Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');

Route::get('/material', [MaterialController::class, 'index'])->name('material.index');
Route::post('/material', [MaterialController::class, 'store'])->name('material.store');
Route::get('/material/create', [MaterialController::class, 'create'])->name('material.create');
Route::get('/material/{id}', [MaterialController::class, 'show'])->name('material.show');

Route::get('/mesin', [MesinController::class, 'index'])->name('mesin.index');
Route::post('/mesin', [MesinController::class, 'store'])->name('mesin.store');
Route::get('/mesin/create', [MesinController::class, 'create'])->name('mesin.create');
Route::get('/mesin/{mesin}', [MesinController::class, 'show'])->name('mesin.show');
Route::get('/mesin/{mesin}/edit', [MesinController::class, 'edit'])->name('mesin.edit');
Route::put('/mesin/{mesin}', [MesinController::class, 'update'])->name('mesin.update');
Route::delete('/mesin/{mesin}', [MesinController::class, 'destroy'])->name('mesin.destroy');