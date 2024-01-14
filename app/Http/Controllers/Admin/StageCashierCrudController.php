<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StageCashierRequest;
use App\Models\Process;
use App\Models\StageCashier;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
/**
 * Class StageCashierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StageCashierCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\ProcessCashierStageOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);
        
        CRUD::setCreateView('crud::operations.create_stage_cashier');
        CRUD::setListView('crud::operations.list_process');

        CRUD::setRoute(config('backpack.base.route_prefix') . '/stage-cashier');
        CRUD::setEntityNameStrings('stage cashier', 'stage cashiers');

        Widget::add()->type('script')->content('assets/js/create_cashier.js');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'stage_id', '1');
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
        CRUD::setValidation(StageCashierRequest::class);
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

    public function createStageCashier(Request $request){
        CRUD::setValidation(StageCashierRequest::class);

        $stageCashier = new StageCashier();
        $stageCashier->process_id = $request->process_id;
        $stageCashier->invoice_reference = $request->invoice_reference;
        $stageCashier->invoice_amount = $request->invoice_amount;
        $stageCashier->variance_explanation = $request->variance_explanation;
        $stageCashier->reciept_reference = $request->reciept_reference;
        $stageCashier->total_amount_paid = $request->total_amount_paid;
        $stageCashier->invoice_status = $request->invoice_status;
        $stageCashier->balance_to_be_paid = $request->balance_to_be_paid;
        $stageCashier->special_instructions = $request->special_instructions;
        $stageCashier->special_authorization = $request->has('special_authorization');

        $invoicePath = $request->file('invoice')->store('documents');
        $receiptPath = $request->file('receipt')->store('documents');
        $otherPath = $request->file('other')->store('documents');

        $stageCashier->invoice = $invoicePath;
        $stageCashier->receipt = $receiptPath;
        $stageCashier->other = $otherPath;

        $stageCashier->save();
        
        $process = Process::find($request->process_id);
        $process->stage_id = 2;
        $process->stage_name = 'Authorisation';
        $process->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
