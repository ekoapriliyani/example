<?php

use App\Http\Controllers\InspeksiWmController;
use App\Http\Controllers\InspeksiWmFgController;
use App\Http\Controllers\InspeksiWmWipController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SubkonController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Bungkus semua route inspeksi QC kamu di dalam middleware auth
Route::middleware('auth')->group(function () {
    
    // Route Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Fitur QC Kamu
    // Route::resource('siswa', SiswaController::class); tidak dipakai
    Route::resource('material', MaterialController::class);
    Route::post('material/import', [MaterialController::class, 'import'])->name('material.import');
    Route::resource('mesin', MesinController::class);

     // Route Subkon
    Route::resource('subkon', SubkonController::class);
    Route::post('subkon/import', [SubkonController::class, 'import'])->name('subkon.import');

    // Route Project
    Route::resource('project', ProjectController::class);
    Route::post('project/import', [ProjectController::class, 'import'])->name('project.import');
    
    // Route Inspeksi WM
    // Route::get('/inspeksi_wm', [InspeksiWmController::class, 'index'])->name('inspeksi_wm.index');
    // Route::get('/inspeksi_wm/create', [InspeksiWmController::class, 'create'])->name('inspeksi_wm.create');
    // Route::post('/inspeksi_wm', [InspeksiWmController::class, 'store'])->name('inspeksi_wm.store');
    // Route::get('/inspeksi_wm/{inspeksi_wm}', [InspeksiWmController::class, 'show'])->name('inspeksi_wm.show');
    // Route::get('/inspeksi_wm/{inspeksi_wm}/edit', [InspeksiWmController::class, 'edit'])->name('inspeksi_wm.edit');
    // Route::delete('/inspeksi_wm/{inspeksi_wm}', [InspeksiWmController::class, 'destroy'])->name('inspeksi_wm.destroy');

    Route::resource('inspeksi_wm', InspeksiWmController::class);

    // Route WIP & FG
    Route::get('/inspeksi_wm/{inspeksi_wm}/wip', [InspeksiWmWipController::class, 'create'])->name('inspeksi_wm.wip');
    Route::post('/inspeksi_wm/wip', [InspeksiWmWipController::class, 'store'])->name('inspeksi_wm_wip.store');
    Route::post('/inspeksi_wm/fg', [InspeksiWmFgController::class, 'store'])->name('inspeksi_wm_fg.store');
    Route::get('/inspeksi_wm/{inspeksi_wm}/fg', [InspeksiWmFgController::class, 'create'])->name('inspeksi_wm.fg');

   


});

require __DIR__.'/auth.php';
