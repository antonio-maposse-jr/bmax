<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\ProductionTask;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;
use App\Models\StageCashier;
use App\Models\StageAuthorisation;
use App\Models\StageCreditControl;
use App\Models\StageDispatch;
use App\Models\StageProduction;

trait ProcessDispatchStageOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupProcessDispatchStageRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/process-dispatch-stage', [
            'as'        => $routeName.'.processDispatchStage',
            'uses'      => $controller.'@processDispatchStage',
            'operation' => 'processDispatchStage',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupProcessDispatchStageDefaults()
    {
        CRUD::allowAccess('processDispatchStage');

        CRUD::operation('processDispatchStage', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'process_dispatch_stage', 'view', 'crud::buttons.process_dispatch_stage');
            CRUD::addButton('line', 'process_dispatch_stage', 'view', 'crud::buttons.process_dispatch_stage');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function processDispatchStage()
    {
        CRUD::hasAccessOrFail('processDispatchStage');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Process Dispatch Stage '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

        if($this->crud->getCurrentEntry()->stage_name != 'Credit Control'){
            $errorMessage = "Error Process no longer in Dispatch Stage";
            return response()->view('error', compact('errorMessage'), 500);
        }
      

        $cashierStage = StageCashier::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['cashier_stage'] =  $cashierStage;

        $authorisationStage = StageAuthorisation::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['authorisation_stage'] =  $authorisationStage;
        
        $productionStage = StageProduction::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['production_stage'] =  $productionStage;

        $creditControlStage = StageCreditControl::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['credit_control_stage'] =  $creditControlStage;

        $dispatchStage = StageDispatch::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['dispatch_stage'] =  $dispatchStage;
        
        $productionTasks = ProductionTask::where('process_id', $this->crud->getCurrentEntry()->id)->get();
        $this->data['production_tasks'] = $productionTasks;

        // load the view
        return view('crud::operations.create_stage_dispatch', $this->data);
    }
}