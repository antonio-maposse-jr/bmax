<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerCrudController;
use App\Http\Controllers\Admin\ProcessCrudController;
use App\Http\Controllers\Admin\ProductCrudController;
use App\Http\Controllers\Admin\StageCashierCrudController;
use App\Http\Controllers\Admin\StageAuthorisationCrudController;
use App\Http\Controllers\Admin\StageProductionCrudController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('subcategory', 'SubcategoryCrudController');
    Route::crud('product', 'ProductCrudController');
    
   
    Route::crud('customer-category', 'CustomerCategoryCrudController');
    Route::crud('process', 'ProcessCrudController');
    
    Route::post('create-new-process', [ProcessCrudController::class,'createNewProcess'])->name('create-new-process');
    Route::post('submit-stage-cashier-data', [StageCashierCrudController::class,'createStageCashier'])->name('submit-stage-cashier-data');
    Route::post('submit-stage-authorisation-data', [StageAuthorisationCrudController::class,'createStageAuthorisation'])->name('submit-stage-authorisation-data');
    Route::post('submit-stage-production-data', [StageProductionCrudController::class,'createProductionStage'])->name('submit-stage-production-data');

    Route::get('get-customers', [CustomerCrudController::class, 'getCustomers'])->name('get-customers');
    Route::get('get-products', [ProductCrudController::class, 'getProducts'])->name('get-products');
    Route::crud('stage-cashier', 'StageCashierCrudController');
    Route::crud('stage-authorisations', 'StageAuthorisationCrudController');
    Route::crud('stage-production', 'StageProductionCrudController');
}); // this should be the absolute last line of this file