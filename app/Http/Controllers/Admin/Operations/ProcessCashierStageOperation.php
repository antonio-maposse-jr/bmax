<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\ReturnStage;
use App\Models\StageCashier;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ProcessCashierStageOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupProcessCashierStageRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/process-cashier-stage', [
            'as'        => $routeName.'.processCashierStage',
            'uses'      => $controller.'@processCashierStage',
            'operation' => 'processCashierStage',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupProcessCashierStageDefaults()
    {
        CRUD::allowAccess('processCashierStage');

        CRUD::operation('processCashierStage', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'process_cashier_stage', 'view', 'crud::buttons.process_cashier_stage');
            CRUD::addButton('line', 'process_cashier_stage', 'view', 'crud::buttons.process_cashier_stage');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function processCashierStage()
    {
        CRUD::hasAccessOrFail('processCashierStage');

        
        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Process Cashier Stage '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

        if($this->crud->getCurrentEntry()->stage_name != 'Cashier'){
            $errorMessage = "Error Process no longer in Cashier Stage";
            return response()->view('error', compact('errorMessage'), 500);
        }

        $cashierStage = StageCashier::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['cashier_stage'] =  $cashierStage;

        $returnStages = ReturnStage::where('process_id', $this->crud->getCurrentEntry()->id)
        ->where('message_status', '1')->get();
        $this->data['return_stages'] = $returnStages;
       
        // load the view
        return view('crud::operations.create_stage_cashier', $this->data);
    }
}