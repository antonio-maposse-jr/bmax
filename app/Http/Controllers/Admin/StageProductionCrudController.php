<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StageProductionRequest;
use App\Models\StageProduction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Models\Process;

/**
 * Class StageProductionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StageProductionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\ProcessProductionStageOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);
        CRUD::setCreateView('crud::operations.create_stage_authorization');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stage-production');
        CRUD::setEntityNameStrings('stage production', 'stage productions');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'stage_id', '3');
        $this->crud->column('customer_id');
        $this->crud->column('product');
        $this->crud->column('date_required');
        $this->crud->column('nr_sheets');
        $this->crud->column('nr_panels');
        $this->crud->column('order_value');
        $this->crud->column('priority_level');
        $this->crud->column('status');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StageProductionRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function createProductionStage(Request $request)
    {
        CRUD::setValidation(StageProductionRequest::class);
        $stageProduction = new StageProduction();

        $stageProduction->cutting = $request->has('cutting');
        $stageProduction->edging = $request->has('edging');
        $stageProduction->cnc_machining = $request->has('cnc_machining');
        $stageProduction->grooving = $request->has('grooving');
        $stageProduction->hinge_boring = $request->has('hinge_boring');
        $stageProduction->wrapping = $request->has('wrapping');
        $stageProduction->sanding = $request->has('sanding');
        $stageProduction->hardware = $request->has('hardware');

        $otherDocPath = $request->file('other_documents')->store('documents');
        $stageProduction->other_documents = $otherDocPath;

        $stageProduction->save();

        $process = Process::find($request->process_id);
        $process->stage_id = 4;
        $process->stage_name = 'Credit Control';
        $process->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
