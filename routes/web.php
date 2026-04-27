<?php

use App\Http\Controllers\IncomingBahanBakuController;
use App\Http\Controllers\InspeksiWmController;
use App\Http\Controllers\InspeksiWmFgController;
use App\Http\Controllers\InspeksiWmWipController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\ProductWmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SheetGalvanizeController;
use App\Http\Controllers\SubkonController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::post('/sync-pro-reference', function () {
    Artisan::call('sync:pro-reference');

    return back()->with('success', Artisan::output());
})->middleware(['auth'])->name('sync.pro.reference');


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

    Route::resource('material', MaterialController::class);
    Route::post('material/import', [MaterialController::class, 'import'])->name('material.import');
    Route::resource('mesin', MesinController::class);
    Route::resource('productwm', ProductWmController::class);
    Route::resource('pro',ProController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('incomingbahanbaku', IncomingBahanBakuController::class);
    Route::resource('sheetgalvanize', SheetGalvanizeController::class);
    Route::resource('lab', LabController::class);
    Route::post('pro/import', [ProController::class, 'import'])->name('pro.import');

     // Route Subkon
    Route::resource('subkon', SubkonController::class);
    Route::post('subkon/import', [SubkonController::class, 'import'])->name('subkon.import');

    // Route Project
    Route::resource('project', ProjectController::class);
    Route::post('project/import', [ProjectController::class, 'import'])->name('project.import');


    Route::resource('inspeksi_wm', InspeksiWmController::class);
    Route::get('/pro/{id}/detail', [InspeksiWmController::class, 'getProDetail'])->name('pros.detail');

    // Route WIP & FG
    Route::get('/inspeksi_wm/{inspeksi_wm}/wip', [InspeksiWmWipController::class, 'create'])->name('inspeksi_wm.wip');
    Route::post('/inspeksi_wm/wip', [InspeksiWmWipController::class, 'store'])->name('inspeksi_wm_wip.store');
    Route::post('/inspeksi_wm/fg', [InspeksiWmFgController::class, 'store'])->name('inspeksi_wm_fg.store');
    Route::get('/inspeksi_wm/{inspeksi_wm}/fg', [InspeksiWmFgController::class, 'create'])->name('inspeksi_wm.fg');

    // Route Incoming Bahan Baku
    //Route::get('/incomingbahanbaku/{incomingbahanbaku}/inspeksi', [IncomingBahanBakuController::class, 'inspeksi'])->name('incomingbahanbaku.inspeksi');

    Route::get('incomingbahanbaku/{id}/inspeksi', [IncomingBahanBakuController::class, 'createInspeksi'])
    ->name('incomingbahanbaku.inspeksi');

    Route::post('incomingbahanbaku/{id}/inspeksi', [IncomingBahanBakuController::class, 'storeInspeksi'])
        ->name('incomingbahanbaku.inspeksi.store');
    
    Route::get('sheetgalvanize/{id}/inspeksi', [SheetGalvanizeController::class, 'createInspeksi'])
        ->name('sheetgalvanize.inspeksi');
        
    Route::post('sheetgalvanize/{id}/inspeksi', [SheetGalvanizeController::class, 'storeInspeksi'])
        ->name('sheetgalvanize.inspeksi.store');


});

require __DIR__.'/auth.php';
