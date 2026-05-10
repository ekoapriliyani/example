<?php

use App\Http\Controllers\IncomingBahanBakuController;
use App\Http\Controllers\IncomingProjectController;
use App\Http\Controllers\IncomingPvcHdpeController;
use App\Http\Controllers\InspeksiKawatDuriController;
use App\Http\Controllers\InspeksiKawatDuriFgController;
use App\Http\Controllers\InspeksiKawatDuriWipController;
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


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Route Profile (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('productwm', ProductWmController::class);
    Route::resource('pro', ProController::class);
    Route::resource('incomingbahanbaku', IncomingBahanBakuController::class);
    Route::resource('incomingpvchdpe', IncomingPvcHdpeController::class);
    Route::resource('incomingproject', IncomingProjectController::class);
    Route::resource('sheetgalvanize', SheetGalvanizeController::class);
    Route::resource('lab', LabController::class);
    Route::post('pro/import', [ProController::class, 'import'])->name('pro.import');

    // Route Project
    Route::resource('project', ProjectController::class);
    Route::post('project/import', [ProjectController::class, 'import'])->name('project.import');


    Route::resource('inspeksi_wm', InspeksiWmController::class);
    Route::resource('inspeksi_kawat_duri', InspeksiKawatDuriController::class);

    Route::get('/pro/{id}/detail', [InspeksiWmController::class, 'getProDetail'])->name('pros.detail');

    // Route WIP & FG
    Route::get('/inspeksi_wm/{inspeksi_wm}/wip', [InspeksiWmWipController::class, 'create'])->name('inspeksi_wm.wip');
    Route::post('/inspeksi_wm/wip', [InspeksiWmWipController::class, 'store'])->name('inspeksi_wm_wip.store');

    Route::get('/inspeksi_wm/{inspeksi_wm}/fg', [InspeksiWmFgController::class, 'create'])->name('inspeksi_wm.fg');
    Route::post('/inspeksi_wm/fg', [InspeksiWmFgController::class, 'store'])->name('inspeksi_wm_fg.store');

    // Route edit WIP & FG
    Route::get('insepeksi_wm/fg/{fg}/edit', [InspeksiWmFgController::class, 'edit'])->name('inspeksi_wm_fg.edit');
    Route::put('insepeksi_wm/fg/{fg}', [InspeksiWmFgController::class, 'update'])->name('inspeksi_wm_fg.update');
    Route::delete('insepeksi_wm/fg/{fg}', [InspeksiWmFgController::class, 'destroy'])->name('inspeksi_wm_fg.destroy');

    Route::get('insepeksi_wm/wip/{wip}/edit', [InspeksiWmWipController::class, 'edit'])->name('inspeksi_wm_wip.edit');
    Route::put('insepeksi_wm/wip/{wip}', [InspeksiWmWipController::class, 'update'])->name('inspeksi_wm_wip.update');
    Route::delete('insepeksi_wm/wip/{wip}', [InspeksiWmWipController::class, 'destroy'])->name('inspeksi_wm_wip.destroy');


    Route::get('/inspeksi_kawat_duri/{inspeksi_kawat_duri}/wip', [InspeksiKawatDuriWipController::class, 'create'])->name('inspeksi_kawat_duri.wip');
    Route::post('/inspeksi_kawat_duri/wip', [InspeksiKawatDuriWipController::class, 'store'])->name('inspeksi_kawat_duri_wip.store');
    Route::get(
        '/inspeksi_kawat_duri/wip/{id}/edit',
        [InspeksiKawatDuriWipController::class, 'edit']
    )->name('inspeksi_kawat_duri_wip.edit');

    Route::put(
        '/inspeksi_kawat_duri/wip/{id}',
        [InspeksiKawatDuriWipController::class, 'update']
    )->name('inspeksi_kawat_duri_wip.update');

    Route::delete(
        '/inspeksi_kawat_duri/wip/{id}',
        [InspeksiKawatDuriWipController::class, 'destroy']
    )->name('inspeksi_kawat_duri_wip.destroy');




    Route::get('/inspeksi_kawat_duri/{inspeksi_kawat_duri}/fg', [InspeksiKawatDuriFgController::class, 'create'])->name('inspeksi_kawat_duri.fg');
    Route::post('/inspeksi_kawat_duri/fg', [InspeksiKawatDuriFgController::class, 'store'])->name('inspeksi_kawat_duri_fg.store');


    // incoming bahan baku
    Route::get('incomingbahanbaku/{id}/inspeksi', [IncomingBahanBakuController::class, 'createInspeksi'])
        ->name('incomingbahanbaku.inspeksi');


    Route::post('incomingbahanbaku/{id}/inspeksi', [IncomingBahanBakuController::class, 'storeInspeksi'])
        ->name('incomingbahanbaku.inspeksi.store');



    Route::get(
        'incomingbahanbaku/{incomingbahanbaku}/inspeksi/{inspeksi}/edit',
        [IncomingBahanBakuController::class, 'editInspeksi']
    )->name('incomingbahanbaku.inspeksi.edit');

    Route::put(
        'incomingbahanbaku/{incomingbahanbaku}/inspeksi/{inspeksi}',
        [IncomingBahanBakuController::class, 'updateInspeksi']
    )->name('incomingbahanbaku.inspeksi.update');

    Route::delete(
        'incomingbahanbaku/inspeksi/{inspeksi}',
        [IncomingBahanBakuController::class, 'destroyInspeksi']
    )->name('incomingbahanbaku.inspeksi.destroy');




    // mechanical test
    Route::get('incomingbahanbaku/{id}/mechanicaltest', [IncomingBahanBakuController::class, 'createMechanicalTest'])
        ->name('incomingbahanbaku.mechanicaltest');

    Route::post('incomingbahanbaku/{id}/mechanicaltest', [IncomingBahanBakuController::class, 'storeMechanicalTest'])
        ->name('incomingbahanbaku.mechanical_test.store');

    Route::get(
        'incomingbahanbaku/mechanicaltest/{mechanicalTest}/edit',
        [IncomingBahanBakuController::class, 'editMechanicalTest']
    )
        ->name('incomingbahanbaku.mechanical_test.edit');

    Route::put(
        'incomingbahanbaku/mechanicaltest/{mechanicalTest}',
        [IncomingBahanBakuController::class, 'updateMechanicalTest']
    )
        ->name('incomingbahanbaku.mechanical_test.update');

    Route::delete(
        'incomingbahanbaku/mechanicaltest/{mechanicalTest}',
        [IncomingBahanBakuController::class, 'destroyMechanicalTest']
    )
        ->name('incomingbahanbaku.mechanical_test.destroy');

    // incoming PVC HDPE
    Route::get('incomingpvchdpe/{id}/inspeksi', [IncomingPvcHdpeController::class, 'createInspeksi'])
        ->name('incomingpvchdpe.inspeksi');

    Route::post('incomingpvchdpe/{id}/inspeksi', [IncomingPvcHdpeController::class, 'storeInspeksi'])
        ->name('incomingpvchdpe.inspeksi.store');

    // incoming project
    Route::get('incomingproject/{id}/inspeksi', [IncomingProjectController::class, 'createInspeksi'])
        ->name('incomingproject.inspeksi');

    Route::post('incomingproject/{id}/inspeksi', [IncomingProjectController::class, 'storeInspeksi'])
        ->name('incomingproject.inspeksi.store');


    // sheet galvanize
    Route::get('sheetgalvanize/{id}/inspeksi', [SheetGalvanizeController::class, 'createInspeksi'])
        ->name('sheetgalvanize.inspeksi');

    Route::post('sheetgalvanize/{id}/inspeksi', [SheetGalvanizeController::class, 'storeInspeksi'])
        ->name('sheetgalvanize.inspeksi.store');
    Route::delete('/sheetgalvanize/inspeksi/{id}', [SheetGalvanizeController::class, 'destroyInspeksi'])
        ->name('sheetgalvanize.inspeksi.destroy');

    Route::get(
        'sheetgalvanize/inspeksi/{inspeksi}/edit',
        [SheetGalvanizeController::class, 'editInspeksi']
    )
        ->name('sheetgalvanize.inspeksi.edit');

    Route::put(
        'sheetgalvanize/inspeksi/{inspeksi}',
        [SheetGalvanizeController::class, 'updateInspeksi']
    )
        ->name('sheetgalvanize.inspeksi.update');
});

Route::middleware([
    'role:supervisor,manager,administrator'
])->group(function () {
    Route::resource('material', MaterialController::class);
    Route::post('material/import', [MaterialController::class, 'import'])
        ->name('material.import');

    Route::resource('mesin', MesinController::class);
    Route::post('mesin/import', [MesinController::class, 'import'])
        ->name('mesin.import');

    Route::resource('productwm', ProductWmController::class);
    Route::post('productwm/import', [ProductWmController::class, 'import'])
        ->name('productwm.import');

    Route::resource('supplier', SupplierController::class);

    Route::resource('subkon', SubkonController::class);
    Route::post('subkon/import', [SubkonController::class, 'import'])
        ->name('subkon.import');

    Route::patch('/inspeksi-wm/{id}/toggle-approval', [InspeksiWmController::class, 'toggleApproval'])
        ->name('inspeksi-wm.toggle');
    Route::patch('/inspeksi-kawat-duri/{id}/toggle-approval', [InspeksiKawatDuriController::class, 'toggleApproval'])
        ->name('inspeksi-kawat-duri.toggle');
});

require __DIR__ . '/auth.php';
