<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\StageCashier;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ProcessAuthorizationStageOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupProcessAuthorizationStageRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/process-authorization-stage', [
            'as'        => $routeName.'.processAuthorizationStage',
            'uses'      => $controller.'@processAuthorizationStage',
            'operation' => 'processAuthorizationStage',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupProcessAuthorizationStageDefaults()
    {
        CRUD::allowAccess('processAuthorizationStage');

        CRUD::operation('processAuthorizationStage', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'process_authorization_stage', 'view', 'crud::buttons.process_authorization_stage');
             CRUD::addButton('line', 'process_authorization_stage', 'view', 'crud::buttons.process_authorization_stage');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function processAuthorizationStage()
    {
        CRUD::hasAccessOrFail('processAuthorizationStage');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Process Authorization Stage '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
      
        $cashierStage = StageCashier::where('process_id', 1)->first();
        $this->data['cashier_stage'] =  $cashierStage;

      //  dd( $this->data);

        // load the view
        return view('crud::operations.create_stage_authorisation', $this->data);
    }
}