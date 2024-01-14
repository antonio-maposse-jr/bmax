<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\StageAuthorisation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;
use App\Models\StageCashier;


trait ProcessProductionStageOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupProcessProductionStageRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/process-production-stage', [
            'as'        => $routeName.'.processProductionStage',
            'uses'      => $controller.'@processProductionStage',
            'operation' => 'processProductionStage',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupProcessProductionStageDefaults()
    {
        CRUD::allowAccess('processProductionStage');

        CRUD::operation('processProductionStage', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'process_production_stage', 'view', 'crud::buttons.process_production_stage');
            CRUD::addButton('line', 'process_production_stage', 'view', 'crud::buttons.process_production_stage');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function processProductionStage()
    {
        CRUD::hasAccessOrFail('processProductionStage');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Process Production Stage '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
      
        $cashierStage = StageCashier::where('process_id', 1)->first();
        $this->data['cashier_stage'] =  $cashierStage;
        $authorisationStage = StageAuthorisation::where('process_id', 1)->first();
        $this->data['authorisation_stage'] =  $authorisationStage;

        // load the view
        return view('crud::operations.create_stage_production', $this->data);
    }
}