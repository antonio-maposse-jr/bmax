<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SMSHelper;
use App\Http\Requests\StageCashierRequest;
use App\Models\Customer;
use App\Models\CustomerSystemNotification;
use App\Models\Process;
use App\Models\ProductionTask;
use App\Models\ReturnStage;
use App\Models\StageCashier;
use App\Models\StageProduction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Widget::add()->type('script')->content('assets/js/production_validations.js');
        Widget::add()->type('script')->content('assets/js/create_cashier.js');
        Widget::add()->type('script')->content('assets/js/stage_config.js');
        Widget::add()->type('script')->content('assets/js/return_stage_popup.js');
        Widget::add()->type('script')->content('assets/js/file_control.js');
        Widget::add()->type('style')->content('assets/css/return_stage_popup.css');

        $permissions = [
            'list' => 'stage_cashiers_list',
            'processCashierStage' => 'stage_cashiers_show',
        ];

        foreach ($permissions as $operation => $permission) {
            if (!backpack_user()->can($permission, 'backpack')) {
                $this->crud->denyAccess([$operation]);
            }
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'stage_id', '2');
        CRUD::addClause('where', 'status', 'PENDING');
        $this->crud->column('id');
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

    public function createStageCashier(StageCashierRequest $request)
    {
       
        $stageCashier = StageCashier::firstOrNew(['process_id' => $request->process_id]);

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
        $stageCashier->user_id = Auth::user()->id;

        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('documents', 'public');
            $stageCashier->invoice = $invoicePath;
        }
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('documents', 'public');
            $stageCashier->receipt = $receiptPath;
        }
        if ($request->hasFile('other')) {
            $otherPath = $request->file('other')->store('documents', 'public');
            $stageCashier->other = $otherPath;
        }

        $stageCashier->save();

        //Remove Return stage messages
        ReturnStage::where('process_id', $request->process_id)->update(['message_status' => false]);

        $process = Process::find($request->process_id);

        if ($request->has('special_authorization')) {
            $process->stage_id = 3;
            $process->stage_name = 'Authorisation';
            $process->save();
        } else {
            $process->stage_id = 4;
            $process->stage_name = 'Production';
            $process->save();
        }

        // Create Production Stage tasks
        $productionStage = StageProduction::firstOrNew(['process_id' => $request->process_id]);
        $productionStage->process_id = $process->id;
        $productionStage->user_id = Auth::user()->id;

        if ($productionStage->total_unallocated_sheets === null || $productionStage->total_unallocated_sheets == 0) {
            $productionStage->total_unallocated_sheets = $process->nr_sheets;
        }
        if ($productionStage->total_unallocated_panels === null || $productionStage->total_unallocated_panels == 0) {
            $productionStage->total_unallocated_panels = $process->nr_panels;
        }
        $productionStage->save();

        $processes = [
            ['name' => 'cutting', 'subTaskNames' => ['CNC1', 'CNC2', 'Panel Saw 1', 'Panel Saw 2']],
            ['name' => 'edging', 'subTaskNames' => ['Edgebander 1', 'Edgebander 2']],
            ['name' => 'cnc_machining', 'subTaskNames' => ['CNC MACHINING']],
            ['name' => 'sanding', 'subTaskNames' => ['SANDING']],
            ['name' => 'grooving', 'subTaskNames' => ['GROOVING']],
            ['name' => 'hinge_boring', 'subTaskNames' => ['HINGE BORING']],
            ['name' => 'wrapping', 'subTaskNames' => ['WRAPPING']],
            ['name' => 'hardware', 'subTaskNames' => ['HARDWARE']],
        ];

        foreach ($processes as $processData) {
            if ($process->{$processData['name']}) {
                foreach ($processData['subTaskNames'] as $subTaskName) {
                    $task = ProductionTask::firstOrNew(['process_id' => $request->process_id, 'sub_task_name' => $subTaskName]);
                    $task->process_id = $process->id;
                    $task->user_id = Auth::user()->id;
                    $task->task_name = $processData['name'];
                    $task->sub_task_name = $subTaskName;
                    $task->save();
                }
            }
        }

        //Check if SMS should be sent
        $notificationExists = CustomerSystemNotification::whereHas('systemNotification', function ($query) {
            $query->where('code', 'ORDER_INVOICING');
        })
            ->where('customer_id', $process->customer_id)
            ->exists();
        //end check

      
        if ($notificationExists) {
            $customer = $process->customer;
            $message = "Dear $customer->name, your Order No. $process->id has been invoiced. Invoice amount $$request->invoice_amount, Invoice balance $$request->balance_to_be_paid. Thank you for doing Business with BoardmartZW";
            $smsResult =  SMSHelper::sendSMS($customer->phone, $message);

            if ($smsResult === 'SMS Sent Successfully.') {
                session()->flash('success', 'SMS sent successfully.');
            } else {
                session()->flash('error', 'Failed to send SMS.');
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
