<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StageCreditControlRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Models\Process;
use App\Models\StageCreditControl;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class StageCreditControlCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StageCreditControlCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\ProcessCreditControlStageOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);
        CRUD::setCreateView('crud::operations.create_stage_credit_control');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stage-credit-control');
        CRUD::setEntityNameStrings('stage credit control', 'stage credit controls');
        Widget::add()->type('script')->content('assets/js/return_stage_popup.js');
        Widget::add()->type('style')->content('assets/css/return_stage_popup.css');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'stage_id', '4');
        $this->crud->column('customer_id');
        $this->crud->column('product');
        $this->crud->column('date_required');
        $this->crud->column('priority_level');
        $this->crud->column('stage_name');
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
        CRUD::setValidation(StageCreditControlRequest::class);
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

    public function createStageCreditControl(Request $request){

        CRUD::setValidation(StageCreditControlRequest::class);

        $stageCreditControl = new StageCreditControl();
        $stageCreditControl->process_id = $request->process_id;
        $stageCreditControl->comment = $request->comment;
        $stageCreditControl->decision = $request->decision;
        $stageCreditControl->comments = $request->comments;
        $stageCreditControl->special_conditions = $request->has('special_conditions');
        
        $otherDocPath = $request->file('other_documents')->store('documents');


        $stageCreditControl->other_documents = $otherDocPath;

        $stageCreditControl->save();
        
        $process = Process::find($request->process_id);
        $process->stage_id = 5;
        $process->stage_name = 'Dispatch';
        $process->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
