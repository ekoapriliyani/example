<?php

use App\Http\Controllers\IncomingBahanBakuController;
use App\Http\Controllers\IncomingProjectController;
use App\Http\Controllers\IncomingPvcHdpeController;
use App\Http\Controllers\InspeksiBendingController;
use App\Http\Controllers\InspeksiBendingFgController;
use App\Http\Controllers\InspeksiBendingWipController;
use App\Http\Controllers\InspeksiChainlinkController;
use App\Http\Controllers\InspeksiChainlinkFgController;
use App\Http\Controllers\InspeksiChainlinkWipController;
use App\Http\Controllers\InspeksiCtController;
use App\Http\Controllers\InspeksiCtFgController;
use App\Http\Controllers\InspeksiCtWipController;
use App\Http\Controllers\InspeksiKawatDuriController;
use App\Http\Controllers\InspeksiKawatDuriFgController;
use App\Http\Controllers\InspeksiKawatDuriWipController;
use App\Http\Controllers\InspeksiKlipController;
use App\Http\Controllers\InspeksiKlipWipController;
use App\Http\Controllers\InspeksiPoundController;
use App\Http\Controllers\InspeksiPoundWipController;
use App\Http\Controllers\InspeksiPvcController;
use App\Http\Controllers\InspeksiRazorpackingController;
use App\Http\Controllers\InspeksiRazorpackingFgController;
use App\Http\Controllers\InspeksiShearingController;
use App\Http\Controllers\InspeksiShearingFgController;
use App\Http\Controllers\InspeksiShearingWipController;
use App\Http\Controllers\InspeksiSlittingController;
use App\Http\Controllers\InspeksiSlittingWipController;
use App\Http\Controllers\InspeksiWmController;
use App\Http\Controllers\InspeksiWmFgController;
use App\Http\Controllers\InspeksiWmWipController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\ProductCtController;
use App\Http\Controllers\ProductFencingController;
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
        'productFencing'     => ProductFencingController::class,
        'productct'         => ProductCtController::class,
        'productRazor'       => ProductRazorController::class,
        'pro'                => ProController::class,
        'project'            => ProjectController::class,
        'incomingbahanbaku'  => IncomingBahanBakuController::class,
        'incomingpvchdpe'    => IncomingPvcHdpeController::class,
        'incomingproject'    => IncomingProjectController::class,
        'sheetgalvanize'     => SheetGalvanizeController::class,
        'lab'                => LabController::class,

        'inspeksi_wm'        => InspeksiWmController::class,
        'inspeksi_ct'        => InspeksiCtController::class,
        'inspeksi_bending'   => InspeksiBendingController::class,
        'inspeksi_wf'   => InspeksiWfController::class,
        'inspeksi_shearing'   => InspeksiShearingController::class,
        'inspeksi_kawat_duri' => InspeksiKawatDuriController::class,
        'inspeksi_pvc' => InspeksiPvcController::class,
        'inspeksi_chainlink' => InspeksiChainlinkController::class,
        'inspeksi_slitting' => InspeksiSlittingController::class,
        'inspeksi_pound' => InspeksiPoundController::class,
        'inspeksi_klip' => InspeksiKlipController::class,
        'inspeksi_razorpacking' => InspeksiRazorpackingController::class,
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
    | CTCL
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_ct/{inspeksi_ct}/wip', [InspeksiCtWipController::class, 'create'])
        ->name('inspeksi_ct.wip');

    Route::post('/inspeksi_ct/wip', [InspeksiCtWipController::class, 'store'])
        ->name('inspeksi_ct_wip.store');

    Route::get('insepeksi_ct/wip/{wip}/edit', [InspeksiCtWipController::class, 'edit'])
        ->name('inspeksi_ct_wip.edit');

    Route::put('insepeksi_ct/wip/{wip}', [InspeksiCtWipController::class, 'update'])
        ->name('inspeksi_ct_wip.update');

    Route::delete('insepeksi_ct/wip/{wip}', [InspeksiCtWipController::class, 'destroy'])
        ->name('inspeksi_ct_wip.destroy');

    // FG
    Route::get('/inspeksi_ct/{inspeksi_ct}/fg', [InspeksiCtFgController::class, 'create'])
        ->name('inspeksi_ct.fg');

    Route::post('/inspeksi_ct/fg', [InspeksiCtFgController::class, 'store'])
        ->name('inspeksi_ct_fg.store');

    Route::get('insepeksi_ct/fg/{fg}/edit', [InspeksiCtFgController::class, 'edit'])
        ->name('inspeksi_ct_fg.edit');

    Route::put('insepeksi_ct/fg/{fg}', [InspeksiCtFgController::class, 'update'])
        ->name('inspeksi_ct_fg.update');

    Route::delete('insepeksi_ct/fg/{fg}', [InspeksiCtFgController::class, 'destroy'])
        ->name('inspeksi_ct_fg.destroy');




    /*
    |--------------------------------------------------------------------------
    | Bending
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_bending/{inspeksi_bending}/wip', [InspeksiBendingWipController::class, 'create'])
        ->name('inspeksi_bending.wip');

    Route::post('/inspeksi_bending/wip', [InspeksiBendingWipController::class, 'store'])
        ->name('inspeksi_bending_wip.store');

    Route::get('insepeksi_bending/wip/{wip}/edit', [InspeksiBendingWipController::class, 'edit'])
        ->name('inspeksi_bending_wip.edit');

    Route::put('insepeksi_bending/wip/{wip}', [InspeksiBendingWipController::class, 'update'])
        ->name('inspeksi_bending_wip.update');

    Route::delete('insepeksi_bending/wip/{wip}', [InspeksiBendingWipController::class, 'destroy'])
        ->name('inspeksi_bending_wip.destroy');

    // FG
    Route::get('/inspeksi_bending/{inspeksi_bending}/fg', [InspeksiBendingFgController::class, 'create'])
        ->name('inspeksi_bending.fg');

    Route::post('/inspeksi_bending/fg', [InspeksiBendingFgController::class, 'store'])
        ->name('inspeksi_bending_fg.store');

    Route::get('insepeksi_bending/fg/{fg}/edit', [InspeksiBendingFgController::class, 'edit'])
        ->name('inspeksi_bending_fg.edit');

    Route::put('insepeksi_bending/fg/{fg}', [InspeksiBendingFgController::class, 'update'])
        ->name('inspeksi_bending_fg.update');

    Route::delete('insepeksi_bending/fg/{fg}', [InspeksiBendingFgController::class, 'destroy'])
        ->name('inspeksi_bending_fg.destroy');



    /*
    |--------------------------------------------------------------------------
    | Shearing
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_shearing/{inspeksi_shearing}/wip', [InspeksiShearingWipController::class, 'create'])
        ->name('inspeksi_shearing.wip');

    Route::post('/inspeksi_shearing/wip', [InspeksiShearingWipController::class, 'store'])
        ->name('inspeksi_shearing_wip.store');

    Route::get('insepeksi_shearing/wip/{wip}/edit', [InspeksiShearingWipController::class, 'edit'])
        ->name('inspeksi_shearing_wip.edit');

    Route::put('insepeksi_shearing/wip/{wip}', [InspeksiShearingWipController::class, 'update'])
        ->name('inspeksi_shearing_wip.update');

    Route::delete('insepeksi_shearing/wip/{wip}', [InspeksiShearingWipController::class, 'destroy'])
        ->name('inspeksi_shearing_wip.destroy');

    // FG
    Route::get('/inspeksi_shearing/{inspeksi_shearing}/fg', [InspeksiShearingFgController::class, 'create'])
        ->name('inspeksi_shearing.fg');

    Route::post('/inspeksi_shearing/fg', [InspeksiShearingFgController::class, 'store'])
        ->name('inspeksi_shearing_fg.store');

    Route::get('insepeksi_shearing/fg/{fg}/edit', [InspeksiShearingFgController::class, 'edit'])
        ->name('inspeksi_shearing_fg.edit');

    Route::put('insepeksi_shearing/fg/{fg}', [InspeksiShearingFgController::class, 'update'])
        ->name('inspeksi_shearing_fg.update');

    Route::delete('insepeksi_shearing/fg/{fg}', [InspeksiShearingFgController::class, 'destroy'])
        ->name('inspeksi_shearing_fg.destroy');




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


    Route::put('inspeksi_slitting/wip/{wip}', [InspeksiSlittingWipController::class, 'update'])
        ->name('inspeksi_slitting_wip.update');

    Route::delete('/inspeksi_slitting/wip/{id}', [InspeksiSlittingWipController::class, 'destroy'])
        ->name('inspeksi_slitting_wip.destroy');



    /*
    |--------------------------------------------------------------------------
    | Pound
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_pound/{inspeksi_pound}/wip', [InspeksiPoundWipController::class, 'create'])
        ->name('inspeksi_pound.wip');

    Route::post('/inspeksi_pound/wip', [InspeksiPoundWipController::class, 'store'])
        ->name('inspeksi_pound_wip.store');

    Route::get('insepeksi_pound/wip/{wip}/edit', [InspeksiPoundWipController::class, 'edit'])
        ->name('inspeksi_pound_wip.edit');


    Route::put('inspeksi_pound/wip/{wip}', [InspeksiPoundWipController::class, 'update'])
        ->name('inspeksi_pound_wip.update');

    Route::delete('/inspeksi_pound/wip/{id}', [InspeksiPoundWipController::class, 'destroy'])
        ->name('inspeksi_pound_wip.destroy');



    /*
    |--------------------------------------------------------------------------
    | Klip
    |--------------------------------------------------------------------------
    */

    // WIP
    Route::get('/inspeksi_klip/{inspeksi_klip}/wip', [InspeksiKlipWipController::class, 'create'])
        ->name('inspeksi_klip.wip');

    Route::post('/inspeksi_klip/wip', [InspeksiKlipWipController::class, 'store'])
        ->name('inspeksi_klip_wip.store');

    Route::get('insepeksi_klip/wip/{wip}/edit', [InspeksiKlipWipController::class, 'edit'])
        ->name('inspeksi_klip_wip.edit');


    Route::put('inspeksi_klip/wip/{wip}', [InspeksiKlipWipController::class, 'update'])
        ->name('inspeksi_klip_wip.update');

    Route::delete('/inspeksi_klip/wip/{id}', [InspeksiKlipWipController::class, 'destroy'])
        ->name('inspeksi_klip_wip.destroy');


    /*
    |--------------------------------------------------------------------------
    | Razorpacking
    |--------------------------------------------------------------------------
    */

    // FG
    Route::get('/inspeksi_razorpacking/{inspeksi_razorpacking}/fg', [InspeksiRazorpackingFgController::class, 'create'])
        ->name('inspeksi_razorpacking.fg');

    Route::post('/inspeksi_razorpacking/fg', [InspeksiRazorpackingFgController::class, 'store'])
        ->name('inspeksi_razorpacking_fg.store');

    Route::get('insepeksi_razorpacking/fg/{fg}/edit', [InspeksiRazorpackingFgController::class, 'edit'])
        ->name('inspeksi_razorpacking_fg.edit');

    Route::put('insepeksi_razorpacking/fg/{fg}', [InspeksiRazorpackingFgController::class, 'update'])
        ->name('inspeksi_razorpacking_fg.update');

    Route::delete('insepeksi_razorpacking/fg/{fg}', [InspeksiRazorpackingFgController::class, 'destroy'])
        ->name('inspeksi_razorpacking_fg.destroy');




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
        'productfencing' => ProductFencingController::class,
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

    Route::post('productfencing/import', [ProductFencingController::class, 'import'])
        ->name('productfencing.import');

    Route::post('productct/import', [ProductCtController::class, 'import'])
        ->name('productct.import');


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

    Route::patch('/inspeksi-bending/{id}/toggle-approval', [InspeksiBendingController::class, 'toggleApproval'])
        ->name('inspeksi-bending.toggle');

    Route::patch('/inspeksi-slitting/{id}/toggle-approval', [InspeksiSlittingController::class, 'toggleApproval'])
        ->name('inspeksi-slitting.toggle');

    Route::patch('/inspeksi-pound/{id}/toggle-approval', [InspeksiPoundController::class, 'toggleApproval'])
        ->name('inspeksi-pound.toggle');

    Route::patch('/inspeksi-klip/{id}/toggle-approval', [InspeksiKlipController::class, 'toggleApproval'])
        ->name('inspeksi-klip.toggle');

    Route::patch('/inspeksi-razorpacking/{id}/toggle-approval', [InspeksiRazorpackingController::class, 'toggleApproval'])
        ->name('inspeksi-razorpacking.toggle');

    Route::patch('/inspeksi-kawat-duri/{id}/toggle-approval', [InspeksiKawatDuriController::class, 'toggleApproval'])
        ->name('inspeksi-kawat-duri.toggle');


    Route::patch('/inspeksi-chainlink/{id}/toggle-approval', [InspeksiChainlinkController::class, 'toggleApproval'])
        ->name('inspeksi-chainlink.toggle');

    Route::patch('/inspeksi-klip/{id}/toggle-approval', [InspeksiKlipController::class, 'toggleApproval'])
        ->name('inspeksi-klip.toggle');

    Route::patch('/inspeksi-ct/{id}/toggle-approval', [InspeksiCtController::class, 'toggleApproval'])
        ->name('inspeksi-ct.toggle');

    Route::patch('/inspeksi-shearing/{id}/toggle-approval', [InspeksiShearingController::class, 'toggleApproval'])
        ->name('inspeksi-shearing.toggle');
});


require __DIR__ . '/auth.php';
