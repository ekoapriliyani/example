<?php

use App\Http\Controllers\IncomingBahanBakuController;
use App\Http\Controllers\IncomingProjectController;
use App\Http\Controllers\IncomingPvcHdpeController;
use App\Http\Controllers\InspeksiChainlinkController;
use App\Http\Controllers\InspeksiChainlinkFgController;
use App\Http\Controllers\InspeksiChainlinkWipController;
use App\Http\Controllers\InspeksiKawatDuriController;
use App\Http\Controllers\InspeksiKawatDuriFgController;
use App\Http\Controllers\InspeksiKawatDuriWipController;
use App\Http\Controllers\InspeksiKlipController;
use App\Http\Controllers\InspeksiPoundController;
use App\Http\Controllers\InspeksiPvcController;
use App\Http\Controllers\InspeksiSlittingController;
use App\Http\Controllers\InspeksiSlittingWipController;
use App\Http\Controllers\InspeksiWmController;
use App\Http\Controllers\InspeksiWmFgController;
use App\Http\Controllers\InspeksiWmWipController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\ProductRazorController;
use App\Http\Controllers\ProductWmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SheetGalvanizeController;
use App\Http\Controllers\SubkonController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Artisan Command
|--------------------------------------------------------------------------
*/

Route::post('/sync-pro-reference', function () {
    Artisan::call('sync:pro-reference');

    return back()->with('success', Artisan::output());
})->middleware(['auth'])->name('sync.pro.reference');


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::controller(ProfileController::class)->group(function () {

        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Master Resource
    |--------------------------------------------------------------------------
    */

    Route::resources([
        'productwm'          => ProductWmController::class,
        'productRazor'       => ProductRazorController::class,
        'pro'                => ProController::class,
        'project'            => ProjectController::class,
        'incomingbahanbaku'  => IncomingBahanBakuController::class,
        'incomingpvchdpe'    => IncomingPvcHdpeController::class,
        'incomingproject'    => IncomingProjectController::class,
        'sheetgalvanize'     => SheetGalvanizeController::class,
        'lab'                => LabController::class,

        'inspeksi_wm'        => InspeksiWmController::class,
        'inspeksi_kawat_duri' => InspeksiKawatDuriController::class,
        'inspeksi_pvc' => InspeksiPvcController::class,
        'inspeksi_chainlink' => InspeksiChainlinkController::class,
        'inspeksi_slitting' => InspeksiSlittingController::class,
        'inspeksi_pound' => InspeksiPoundController::class,
        'inspeksi_klip' => InspeksiKlipController::class,
    ]);


    /*
    |--------------------------------------------------------------------------
    | Import
    |--------------------------------------------------------------------------
    */

    Route::post('pro/import', [ProController::class, 'import'])
        ->name('pro.import');

    Route::post('project/import', [ProjectController::class, 'import'])
        ->name('project.import');


    /*
    |--------------------------------------------------------------------------
    | PRO Detail
    |--------------------------------------------------------------------------
    */

    Route::get('/pro/{id}/detail', [InspeksiWmController::class, 'getProDetail'])
        ->name('pros.detail');


    /*
    |--------------------------------------------------------------------------
    | WM
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_wm/{inspeksi_wm}/wip', [InspeksiWmWipController::class, 'create'])
        ->name('inspeksi_wm.wip');

    Route::post('/inspeksi_wm/wip', [InspeksiWmWipController::class, 'store'])
        ->name('inspeksi_wm_wip.store');

    Route::get('insepeksi_wm/wip/{wip}/edit', [InspeksiWmWipController::class, 'edit'])
        ->name('inspeksi_wm_wip.edit');

    Route::put('insepeksi_wm/wip/{wip}', [InspeksiWmWipController::class, 'update'])
        ->name('inspeksi_wm_wip.update');

    Route::delete('insepeksi_wm/wip/{wip}', [InspeksiWmWipController::class, 'destroy'])
        ->name('inspeksi_wm_wip.destroy');

    // FG
    Route::get('/inspeksi_wm/{inspeksi_wm}/fg', [InspeksiWmFgController::class, 'create'])
        ->name('inspeksi_wm.fg');

    Route::post('/inspeksi_wm/fg', [InspeksiWmFgController::class, 'store'])
        ->name('inspeksi_wm_fg.store');

    Route::get('insepeksi_wm/fg/{fg}/edit', [InspeksiWmFgController::class, 'edit'])
        ->name('inspeksi_wm_fg.edit');

    Route::put('insepeksi_wm/fg/{fg}', [InspeksiWmFgController::class, 'update'])
        ->name('inspeksi_wm_fg.update');

    Route::delete('insepeksi_wm/fg/{fg}', [InspeksiWmFgController::class, 'destroy'])
        ->name('inspeksi_wm_fg.destroy');



    /*
    |--------------------------------------------------------------------------
    | Slitting
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_slitting/{inspeksi_slitting}/wip', [InspeksiSlittingWipController::class, 'create'])
        ->name('inspeksi_slitting.wip');

    Route::post('/inspeksi_slitting/wip', [InspeksiSlittingWipController::class, 'store'])
        ->name('inspeksi_slitting_wip.store');

    Route::get('insepeksi_slitting/wip/{wip}/edit', [InspeksiSlittingWipController::class, 'edit'])
        ->name('inspeksi_slitting_wip.edit');


    /*
    |--------------------------------------------------------------------------
    | Kawat Duri
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_kawat_duri/{inspeksi_kawat_duri}/wip', [InspeksiKawatDuriWipController::class, 'create'])
        ->name('inspeksi_kawat_duri.wip');

    Route::post('/inspeksi_kawat_duri/wip', [InspeksiKawatDuriWipController::class, 'store'])
        ->name('inspeksi_kawat_duri_wip.store');

    Route::get('inspeksi_kawat_duri/wip/{wip}/edit', [InspeksiKawatDuriWipController::class, 'edit'])
        ->name('inspeksi_kawat_duri_wip.edit');

    Route::put('inspeksi_kawat_duri/wip/{wip}', [InspeksiKawatDuriWipController::class, 'update'])
        ->name('inspeksi_kawat_duri_wip.update');

    Route::delete('/inspeksi_kawat_duri/wip/{id}', [InspeksiKawatDuriWipController::class, 'destroy'])
        ->name('inspeksi_kawat_duri_wip.destroy');

    // FG
    Route::get('/inspeksi_kawat_duri/{inspeksi_kawat_duri}/fg', [InspeksiKawatDuriFgController::class, 'create'])
        ->name('inspeksi_kawat_duri.fg');

    Route::post('/inspeksi_kawat_duri/fg', [InspeksiKawatDuriFgController::class, 'store'])
        ->name('inspeksi_kawat_duri_fg.store');

    Route::get('insepeksi_kawat_duri/fg/{fg}/edit', [InspeksiKawatDuriFgController::class, 'edit'])
        ->name('inspeksi_kawat_duri_fg.edit');

    Route::put('insepeksi_kawat_duri/fg/{fg}', [InspeksiKawatDuriFgController::class, 'update'])
        ->name('inspeksi_kawat_duri_fg.update');

    Route::delete('insepeksi_kawat_duri/fg/{fg}', [InspeksiKawatDuriFgController::class, 'destroy'])
        ->name('inspeksi_kawat_duri_fg.destroy');


    /*
    |--------------------------------------------------------------------------
    | Chainlink
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_chainlink/{inspeksi_chainlink}/wip', [InspeksiChainlinkWipController::class, 'create'])
        ->name('inspeksi_chainlink.wip');

    Route::post('/inspeksi_chainlink/wip', [InspeksiChainlinkWipController::class, 'store'])
        ->name('inspeksi_chainlink_wip.store');

    Route::get('inspeksi_chainlink/wip/{wip}/edit', [InspeksiChainlinkWipController::class, 'edit'])
        ->name('inspeksi_chainlink_wip.edit');

    Route::put('inspeksi_chainlink/wip/{wip}', [InspeksiChainlinkWipController::class, 'update'])
        ->name('inspeksi_chainlink_wip.update');

    Route::delete('/inspeksi_chainlink/wip/{id}', [InspeksiChainlinkWipController::class, 'destroy'])
        ->name('inspeksi_chainlink_wip.destroy');

    // FG
    Route::get('/inspeksi_chainlink/{inspeksi_chainlink}/fg', [InspeksiChainlinkFgController::class, 'create'])
        ->name('inspeksi_chainlink.fg');

    Route::post('/inspeksi_chainlink/fg', [InspeksiChainlinkFgController::class, 'store'])
        ->name('inspeksi_chainlink_fg.store');

    Route::get('insepeksi_chainlink/fg/{fg}/edit', [InspeksiChainlinkFgController::class, 'edit'])
        ->name('inspeksi_chainlink_fg.edit');

    Route::put('insepeksi_chainlink/fg/{fg}', [InspeksiChainlinkFgController::class, 'update'])
        ->name('inspeksi_chainlink_fg.update');

    Route::delete('insepeksi_chainlink/fg/{fg}', [InspeksiChainlinkFgController::class, 'destroy'])
        ->name('inspeksi_chainlink_fg.destroy');


    /*
    |--------------------------------------------------------------------------
    | Incoming Bahan Baku - Inspeksi
    |--------------------------------------------------------------------------
    */

    Route::controller(IncomingBahanBakuController::class)->group(function () {

        Route::get('incomingbahanbaku/{id}/inspeksi', 'createInspeksi')
            ->name('incomingbahanbaku.inspeksi');

        Route::post('incomingbahanbaku/{id}/inspeksi', 'storeInspeksi')
            ->name('incomingbahanbaku.inspeksi.store');

        Route::get(
            'incomingbahanbaku/{incomingbahanbaku}/inspeksi/{inspeksi}/edit',
            'editInspeksi'
        )->name('incomingbahanbaku.inspeksi.edit');

        Route::put(
            'incomingbahanbaku/{incomingbahanbaku}/inspeksi/{inspeksi}',
            'updateInspeksi'
        )->name('incomingbahanbaku.inspeksi.update');

        Route::delete(
            'incomingbahanbaku/inspeksi/{inspeksi}',
            'destroyInspeksi'
        )->name('incomingbahanbaku.inspeksi.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Mechanical Test
    |--------------------------------------------------------------------------
    */

    Route::controller(IncomingBahanBakuController::class)->group(function () {

        Route::get('incomingbahanbaku/{id}/mechanicaltest', 'createMechanicalTest')
            ->name('incomingbahanbaku.mechanicaltest');

        Route::post('incomingbahanbaku/{id}/mechanicaltest', 'storeMechanicalTest')
            ->name('incomingbahanbaku.mechanical_test.store');

        Route::get(
            'incomingbahanbaku/mechanicaltest/{mechanicalTest}/edit',
            'editMechanicalTest'
        )->name('incomingbahanbaku.mechanical_test.edit');

        Route::put(
            'incomingbahanbaku/mechanicaltest/{mechanicalTest}',
            'updateMechanicalTest'
        )->name('incomingbahanbaku.mechanical_test.update');

        Route::delete(
            'incomingbahanbaku/mechanicaltest/{mechanicalTest}',
            'destroyMechanicalTest'
        )->name('incomingbahanbaku.mechanical_test.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Incoming PVC HDPE
    |--------------------------------------------------------------------------
    */

    Route::controller(IncomingPvcHdpeController::class)->group(function () {

        Route::get('incomingpvchdpe/{id}/inspeksi', 'createInspeksi')
            ->name('incomingpvchdpe.inspeksi');

        Route::post('incomingpvchdpe/{id}/inspeksi', 'storeInspeksi')
            ->name('incomingpvchdpe.inspeksi.store');
    });


    /*
    |--------------------------------------------------------------------------
    | Incoming Project
    |--------------------------------------------------------------------------
    */

    Route::controller(IncomingProjectController::class)->group(function () {

        Route::get('incomingproject/{id}/inspeksi', 'createInspeksi')
            ->name('incomingproject.inspeksi');

        Route::post('incomingproject/{id}/inspeksi', 'storeInspeksi')
            ->name('incomingproject.inspeksi.store');
    });


    /*
    |--------------------------------------------------------------------------
    | Sheet Galvanize
    |--------------------------------------------------------------------------
    */

    Route::controller(SheetGalvanizeController::class)->group(function () {

        Route::get('sheetgalvanize/{id}/inspeksi', 'createInspeksi')
            ->name('sheetgalvanize.inspeksi');

        Route::post('sheetgalvanize/{id}/inspeksi', 'storeInspeksi')
            ->name('sheetgalvanize.inspeksi.store');

        Route::delete('/sheetgalvanize/inspeksi/{id}', 'destroyInspeksi')
            ->name('sheetgalvanize.inspeksi.destroy');

        Route::get(
            'sheetgalvanize/inspeksi/{inspeksi}/edit',
            'editInspeksi'
        )->name('sheetgalvanize.inspeksi.edit');

        Route::put(
            'sheetgalvanize/inspeksi/{inspeksi}',
            'updateInspeksi'
        )->name('sheetgalvanize.inspeksi.update');
    });
});


/*
|--------------------------------------------------------------------------
| Role Access
|--------------------------------------------------------------------------
*/

Route::middleware([
    'role:supervisor,manager,administrator'
])->group(function () {

    Route::resources([
        'material' => MaterialController::class,
        'mesin'    => MesinController::class,
        'productwm' => ProductWmController::class,
        'productrazor' => ProductRazorController::class,
        'supplier' => SupplierController::class,
        'subkon'   => SubkonController::class,
    ]);


    /*
    |--------------------------------------------------------------------------
    | Import
    |--------------------------------------------------------------------------
    */

    Route::post('material/import', [MaterialController::class, 'import'])
        ->name('material.import');

    Route::post('mesin/import', [MesinController::class, 'import'])
        ->name('mesin.import');

    Route::post('productwm/import', [ProductWmController::class, 'import'])
        ->name('productwm.import');
    Route::post('productrazor/import', [ProductRazorController::class, 'import'])
        ->name('productrazor.import');

    Route::post('subkon/import', [SubkonController::class, 'import'])
        ->name('subkon.import');


    /*
    |--------------------------------------------------------------------------
    | Approval
    |--------------------------------------------------------------------------
    */

    Route::patch('/inspeksi-wm/{id}/toggle-approval', [InspeksiWmController::class, 'toggleApproval'])
        ->name('inspeksi-wm.toggle');

    Route::patch('/inspeksi-slitting/{id}/toggle-approval', [InspeksiSlittingController::class, 'toggleApproval'])
        ->name('inspeksi-slitting.toggle');

    Route::patch('/inspeksi-kawat-duri/{id}/toggle-approval', [InspeksiKawatDuriController::class, 'toggleApproval'])
        ->name('inspeksi-kawat-duri.toggle');

    Route::patch('/inspeksi-chainlink/{id}/toggle-approval', [InspeksiChainlinkController::class, 'toggleApproval'])
        ->name('inspeksi-chainlink.toggle');
});


require __DIR__ . '/auth.php';
