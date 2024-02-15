<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\ProductionTask;
use App\Models\ReasonDecline;
use App\Models\StageAuthorisation;
use App\Models\StageCashier;
use App\Models\StageCreditControl;
use App\Models\StageDispatch;
use App\Models\StageProduction;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait ViewProcessOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupViewProcessRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/view-process', [
            'as'        => $routeName.'.viewProcess',
            'uses'      => $controller.'@viewProcess',
            'operation' => 'viewProcess',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupViewProcessDefaults()
    {
        CRUD::allowAccess('viewProcess');

        CRUD::operation('viewProcess', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'view_process', 'view', 'crud::buttons.view_process');
            CRUD::addButton('line', 'view_process', 'view', 'crud::buttons.view_process');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function viewProcess()
    {
        CRUD::hasAccessOrFail('viewProcess');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'View Process '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

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

        $reasonDeclines = ReasonDecline::where('process_id', $this->crud->getCurrentEntry()->id)->get();
        $this->data['reason_declines'] = $reasonDeclines;

        return view('crud::operations.view_process', $this->data);
    }
}