<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WhatsappHelper;
use App\Http\Requests\StageDispatchRequest;
use App\Models\CustomerSystemNotification;
use App\Models\StageDispatch;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;
use App\Models\Process;
use App\Models\ReturnStage;
use App\Models\StageCashier;
use App\Notifications\DispatchStageComplete;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\Notification;

/**
 * Class StageDispatchCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StageDispatchCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\ProcessDispatchStageOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stage-dispatch');
        CRUD::setEntityNameStrings('stage dispatch', 'stage dispatches');
        Widget::add()->type('script')->content('assets/js/file_control.js');
        Widget::add()->type('script')->content('assets/js/stage_config.js');
        Widget::add()->type('script')->content('assets/js/return_stage_popup.js');
        Widget::add()->type('style')->content('assets/css/return_stage_popup.css');
        Widget::add()->type('script')->content('assets/js/production_validations.js');
        Widget::add()->type('style')->content('assets/css/other.css');

        $permissions = [
            'list' => 'stage_dispatches_list',
            'processDispatchStage' => 'stage_dispatches_show',
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
        CRUD::addClause('where', 'stage_id', '6');
        CRUD::addClause('where', 'status', 'PENDING');
        $this->crud->column('id');
        $this->crud->column('customer_id');
        $this->crud->column('date_required');
        $this->crud->column('priority_level');
        $this->crud->column('stage_name');
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'custom_html',
            'value' => function ($entry) {
                switch ($entry->status) {
                    case 'PROCESSING':
                        return '<span class="badge badge-pill badge-info">' . $entry->status . '</span>';
                        break;
                    case 'PENDING':
                        return '<span class="badge badge-pill badge-warning">' . $entry->status . '</span>';
                        break;
                    case 'PAUSED':
                        return '<span class="badge badge-pill badge-danger">' . $entry->status . '</span>';
                        break;
                    case 'COMPLETED':
                        return '<span class="badge badge-pill badge-success">' . $entry->status . '</span>';
                        break;
                    default:
                        return $entry->status;
                }
            }
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StageDispatchRequest::class);
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

    public function createStageDispatch(StageDispatchRequest $request){

        $stageDispatch = StageDispatch::firstOrNew(['process_id' => $request->process_id]);
        $stageDispatch->process_id = $request->process_id;
        $stageDispatch->comment = $request->comment;
        $stageDispatch->dispatch_status = $request->dispatch_status;
        $stageDispatch->nr_panels = $request->nr_panels;
        $stageDispatch->user_id = Auth::user()->id;

        $stageDispatch->save();

        ReturnStage::where('process_id', $request->process_id)->update(['message_status' => false]);
        
        $process = Process::find($request->process_id);
        $process->stage_id = 0;
        $process->stage_name = 'N/A';
        $process->status = 'COMPLETED';
        $process->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

          //Check if SMS should be sent
          $notificationExists = CustomerSystemNotification::whereHas('systemNotification', function ($query) {
            $query->where('code', 'ORDER_DISPATCH');
        })
        ->where('customer_id', $process->customer_id)
        ->exists();
        //end check
       
        if ($notificationExists) {
            $customer = $process->customer;
            $message= [
                "customer_name" => "$customer->name",
                "process_id" => "$process->id",
            ];
            $messageSid = "HX39667afb98a2d98e994360ce420494d0";
            $whatsappResult =  WhatsappHelper::sendWhatsapp($customer->phone, $message, $messageSid);

            if ($whatsappResult === 'Message Sent Successfully.') {
                session()->flash('success', 'Message sent successfully.');
            } else {
                session()->flash('error', 'Failed to send Message.');
            }
        }
        $cashierStage = StageCashier::where('process_id', $request->process_id)->first();

        $orderData = [
            'customer_name' =>  $process->customer->name,
            'order_number' => $process->id,
            'invoice_value' => $cashierStage->invoice_amount,
            'amount_paid' => '$'.$cashierStage->total_amount_paid,
            'sales_person' => $process->user->name,
            'customer_name' => $process->customer->name,
        ];
        Notification::route('mail', $process->customer->email)
            ->notify(new DispatchStageComplete($orderData));

        return redirect(url($this->crud->route));
    }
}
