<?php

use App\Http\Controllers\Admin\ColorCrudController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerCrudController;
use App\Http\Controllers\Admin\ProcessCrudController;
use App\Http\Controllers\Admin\ProductCrudController;
use App\Http\Controllers\Admin\ReasonDeclineCrudController;
use App\Http\Controllers\Admin\RegularReportsController;
use App\Http\Controllers\Admin\StageCashierCrudController;
use App\Http\Controllers\Admin\StageAuthorisationCrudController;
use App\Http\Controllers\Admin\StageCreditControlCrudController;
use App\Http\Controllers\Admin\StageDispatchCrudController;
use App\Http\Controllers\Admin\StageProductionCrudController;
use App\Http\Controllers\Admin\StageSalesCrudController;
use App\Http\Controllers\Admin\SystemNotificationCrudController;
use App\Models\StageProduction;

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
    
    Route::get('/send-email', [CustomerCrudController::class, 'sendEmail'])->name('send.email');
    Route::get('/send-whatsapp', [CustomerCrudController::class, 'sendWhatsapp'])->name('send.whatsapp');
    Route::post('create-customer-with-notifications', [CustomerCrudController::class,'createCustomerData'])->name('create-customer-with-notifications');
    Route::crud('customer-category', 'CustomerCategoryCrudController');
    Route::crud('process', 'ProcessCrudController');

  
    Route::post('return-stage', [ProcessCrudController::class,'returnStage'])->name('return-stage');
    
    Route::post('submit-sales-stage', [StageSalesCrudController::class,'submitSales'])->name('submit-sales-stage');
    Route::post('create-new-process', [ProcessCrudController::class,'createNewProcess'])->name('create-new-process');
    Route::post('submit-stage-cashier-data', [StageCashierCrudController::class,'createStageCashier'])->name('submit-stage-cashier-data');
    Route::post('submit-stage-authorisation-data', [StageAuthorisationCrudController::class,'createStageAuthorisation'])->name('submit-stage-authorisation-data');
    Route::post('submit-stage-production-data', [StageProductionCrudController::class,'createProductionStage'])->name('submit-stage-production-data');
    Route::post('submit-stage-credit-control-data', [StageCreditControlCrudController::class,'createStageCreditControl'])->name('submit-stage-credit-control-data');
    Route::post('submit-stage-dispatch-data', [StageDispatchCrudController::class,'createStageDispatch'])->name('submit-stage-dispatch-data');

    Route::post('submit-prod-task', [StageProductionCrudController::class,'updateTask'])->name('submit-prod-task');
    Route::post('assign-prod-task', [StageProductionCrudController::class,'assignTask'])->name('assign-prod-task');
    Route::post('assign-prod-panels', [StageProductionCrudController::class,'assignPanels'])->name('assign-prod-panels');
    Route::post('decline-process', [ReasonDeclineCrudController::class,'declineProcess'])->name('decline-process');
    
    //Notifications
    Route::post('save-notifications', [SystemNotificationCrudController::class,'saveNotifications'])->name('save-notifications');

    //Reports
    Route::post('get-users-report', [RegularReportsController::class,'reportsIndex'])->name('get-users-report');

    //End Reports
    Route::get('get-customers', [CustomerCrudController::class, 'getCustomers'])->name('get-customers');
    Route::get('get-products', [ProductCrudController::class, 'getProducts'])->name('get-products');


    Route::crud('stage-cashier', 'StageCashierCrudController');
    Route::crud('stage-authorisations', 'StageAuthorisationCrudController');
    Route::crud('stage-production', 'StageProductionCrudController');
    Route::crud('stage-credit-control', 'StageCreditControlCrudController');
    Route::crud('stage-dispatch', 'StageDispatchCrudController');
    Route::crud('reason-decline', 'ReasonDeclineCrudController');
    Route::crud('pendig-process', 'PendigProcessCrudController');
    Route::crud('completed-process', 'CompletedProcessCrudController');
    Route::get('regular_reports', 'RegularReportsController@index')->name('page.regular_reports.index');
    Route::get('sales_report', 'SalesReportController@index')->name('page.sales_report.index');
    Route::crud('stage-sales', 'StageSalesCrudController');
    Route::crud('system-notification', 'SystemNotificationCrudController');
}); // this should be the absolute last line of this file