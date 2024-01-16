<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\ReturnStage;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;
use App\Models\StageCashier;
use App\Models\StageAuthorisation;
use App\Models\StageCreditControl;
use App\Models\StageProduction;

trait ProcessCreditControlStageOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupProcessCreditControlStageRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/process-credit-control-stage', [
            'as'        => $routeName.'.processCreditControlStage',
            'uses'      => $controller.'@processCreditControlStage',
            'operation' => 'processCreditControlStage',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupProcessCreditControlStageDefaults()
    {
        CRUD::allowAccess('processCreditControlStage');

        CRUD::operation('processCreditControlStage', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'process_credit_control_stage', 'view', 'crud::buttons.process_credit_control_stage');
            CRUD::addButton('line', 'process_credit_control_stage', 'view', 'crud::buttons.process_credit_control_stage');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function processCreditControlStage()
    {
        CRUD::hasAccessOrFail('processCreditControlStage');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Process Credit Control Stage '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
      
        $cashierStage = StageCashier::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['cashier_stage'] =  $cashierStage;
        $authorisationStage = StageAuthorisation::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['authorisation_stage'] =  $authorisationStage;
        $productionStage = StageProduction::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['production_stage'] =  $productionStage;
        $creditControlStage = StageCreditControl::where('process_id', $this->crud->getCurrentEntry()->id)->first();
        $this->data['credit_control_stage'] =  $creditControlStage;
        $returnStages = ReturnStage::where('process_id', $this->crud->getCurrentEntry()->id)
        ->where('message_status', '1')->get();
        $this->data['return_stages'] = $returnStages;

        // load the view
        return view('crud::operations.create_stage_credit_control', $this->data);
    }
}