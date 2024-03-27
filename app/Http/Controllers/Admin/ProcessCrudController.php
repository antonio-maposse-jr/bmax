<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WhatsappHelper;
use App\Http\Requests\ProcessRequest;
use App\Models\Customer;
use App\Models\CustomerSystemNotification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use App\Models\Process;
use App\Models\ProcessProduct;
use App\Models\ReturnStage;
use Illuminate\Support\Facades\Auth;


/**
 * Class ProcessCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProcessCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\ViewProcessOperation;
    // use \Backpack\ActivityLog\Http\Controllers\Operations\ModelActivityOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);

        CRUD::setCreateView('crud::operations.create_process');

        CRUD::setRoute(config('backpack.base.route_prefix') . '/process');
        CRUD::setEntityNameStrings('process', 'processes');

        $permissions = [
            'list' => 'processes_list',
            'create' => 'processes_create',
            'update' => 'processes_update',
            'delete' => 'processes_delete',
            'viewProcess' => 'processes_show',
        ];
        
        foreach ($permissions as $operation => $permission) {
            if (!backpack_user()->can($permission, 'backpack')) {
                $this->crud->denyAccess([$operation]);
            }
        }


        Widget::add()->type('style')->content('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
        Widget::add()->type('script')->content('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js');

        Widget::add()->type('script')->content('assets/js/process.js');
        Widget::add()->type('style')->content('assets/css/select2_custom.css');
        Widget::add()->type('style')->content('assets/css/return_stage_popup.css');
        Widget::add()->type('style')->content('assets/css/other.css');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
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
                    case 'DECLINED':
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
        // CRUD::setValidation(ProcessRequest::class);
        CRUD::addField([
            'label' => 'Customer',
            'type' => 'select',
            'name' => 'customer_id', // This name should match the relationship method in your Product model
            'entity' => 'Customer',
            'model' => 'App\Models\Customer',
            'ajax'          => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Form'
        ]);


        CRUD::addField([
            'label' => 'Product',
            'type' => 'select',
            'name' => 'product_id', // This name should match the relationship method in your Product model
            'entity' => 'Product',
            'model' => 'App\Models\Product',
            'ajax'          => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'tab' => 'Form',
            'attributes' => [
                'multiple'       => 'true',
            ]
        ]);

        CRUD::addField([
            'label' => 'Creator User',
            'type' => 'select',
            'name' => 'user_id', // This name should match the relationship method in your Product model
            'entity' => 'User',
            'model' => 'App\Models\User',
            'ajax'          => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
            'disabled'       => 'true',
            'tab' => 'Form'
        ]);

        CRUD::field('nr_sheets')->type('number')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Form');

        CRUD::field('nr_panels')->type('number')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Form');

        CRUD::field('order_value')->type('number')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Form');

        CRUD::field('estimated_process_time')->type('number')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Form');

        CRUD::field('date_required')->type('date')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Form');

        CRUD::field([
            'name' => 'priority_level',
            'type' => 'select_from_array',
            'options' => ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'],
            'allows_null' => false,
            'default' => 'one',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ])->tab('Form');

        CRUD::field([
            'name' => 'order_confirmation',
            'type' => 'select_from_array',
            'options' => ['Call' => 'Call', 'Email' => 'Email', 'In person' => 'In person'],
            'allows_null' => false,
            'default' => 'one',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ])->tab('Form');


        CRUD::field('cutting')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('edging')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('cnc_machining')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('grooving')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('hinge_boring')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('wrapping')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('sanding')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');
        CRUD::field('hardware')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
            ])->tab('Checklist');

        CRUD::field('job_reference')->type('textarea')->tab('Form');

        CRUD::field('job_layout')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;

        CRUD::field('cutting_list')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;

        CRUD::field('quote')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;

        CRUD::field('confirmation_call_record')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;

        CRUD::field('signed_confirmation')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;

        CRUD::field('custom_cutting_list')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;

        CRUD::field('other_document')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'documents', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ])->tab('Documents');;
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

    public function createNewProcess(ProcessRequest $request)
    {
 
        //Basic Fields Process
        $process = new Process();
        $process->customer_id = $request->customer_id;
        $process->user_id = $request->user_id;
        $process->nr_sheets = $request->nr_sheets;
        $process->nr_panels = $request->nr_panels;
        $process->order_value = $request->order_value;
        $process->estimated_process_time = $request->estimated_process_time;
        $process->date_required = $request->date_required;
        $process->priority_level = $request->priority_level;
        $process->job_reference = $request->job_reference;
        $process->order_confirmation = $request->order_confirmation;
        //End Basic Fields Process

        //Save files
        if ($request->hasFile('job_layout')) {
            $jobLayoutPath = $request->file('job_layout')->store('documents', 'public');
            $process->job_layout = $jobLayoutPath;
        }
        if ($request->hasFile('cutting_list')) {
            $cuttingListPath = $request->file('cutting_list')->store('documents', 'public');
            $process->cutting_list = $cuttingListPath;
        }
        if ($request->hasFile('quote')) {
            $quotePath = $request->file('quote')->store('documents', 'public');
            $process->quote = $quotePath;
        }

        if ($request->hasFile('confirmation_call_record')) {
            $confirmationCallRecordPath = $request->file('confirmation_call_record')->store('documents', 'public');
            $process->confirmation_call_record = $confirmationCallRecordPath;
        }
        if ($request->hasFile('signed_confirmation')) {
            $signedConfirmationPath = $request->file('signed_confirmation')->store('documents', 'public');
            $process->signed_confirmation = $signedConfirmationPath;
        }
        if ($request->hasFile('custom_cutting_list')) {
            $customCuttingListPath = $request->file('custom_cutting_list')->store('documents', 'public');
            $process->custom_cutting_list = $customCuttingListPath;
        }
        if ($request->hasFile('other_document')) {
            $otherDocumentsPath = $request->file('other_document')->store('documents', 'public');
            $process->other_document = $otherDocumentsPath;
        }
        //End of File Save

        //Checkboxes
        $process->cutting = $request->has('cutting');
        $process->edging = $request->has('edging');
        $process->cnc_machining = $request->has('cnc_machining');
        $process->grooving = $request->has('grooving');
        $process->hinge_boring = $request->has('hinge_boring');
        $process->wrapping = $request->has('wrapping');
        $process->sanding = $request->has('sanding');
        $process->hardware = $request->has('hardware');

        $process->stage_id = 2;

        $process->save();

        $selectedProductIds = $request->key_products;
        foreach ($selectedProductIds as $productId) {
          $processProduct = new ProcessProduct();
          $processProduct->process_id = $process->id;
          $processProduct->product_id = $productId;

          $processProduct->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        //Check if SMS should be sent
        $notificationExists = CustomerSystemNotification::whereHas('systemNotification', function ($query) {
            $query->where('code', 'ORDER_CREATION');
        })
        ->where('customer_id', $request->customer_id)
        ->exists();
        //end check

       // dd($notificationExists);
        if ($notificationExists) {
            $customer = Customer::with('notifications')->find($request->customer_id);
            $message= [
                "customer_name" => "$customer->name",
                "order_value" => "$process->order_value",
                "process_id" => "$process->id",
            ];
            $messageSid = "HXf754a97259f0450c1f7b069fdf843dcb";
            $whatsappResult =  WhatsappHelper::sendWhatsapp($customer->phone, $message, $messageSid);

            if ($whatsappResult === 'Message Sent Successfully.') {
                session()->flash('success', 'Message sent successfully.');
            } else {
                session()->flash('error', 'Failed to send Message.');
            }
        }

        return redirect(url($this->crud->route));
    }

    protected function getStageById($id)
    {
        switch ($id) {
            case 1:
                return "Sales";
            case 2:
                return "Cashier";
            case 3:
                return "Authorisation";
            case 4:
                return "Production";
            case 5:
                return "Credit Control";
            case 6:
                return "Dispatch";
            default:
                return "Unknown Stage";
        }
    }

    public function returnStage(Request $request)
    {
        $returnStage = new ReturnStage();

        $returnStage->process_id = $request->process_id;
        $returnStage->origin_stage_nr = $request->origin_stage_nr;
        $returnStage->origin_stage_name = $request->origin_stage_name;
        $returnStage->destination_stage_nr = $request->destination_stage_nr;
        $returnStage->destination_stage_name = $this->getStageById($request->destination_stage_nr);
        $returnStage->reason = $request->reason;
        $returnStage->comment = $request->comment;
        $returnStage->message_status = true;
        $returnStage->user_id = Auth::user()->id;


        $returnStage->save();

        $process = Process::find($request->process_id);
        $process->stage_id = $request->destination_stage_nr;
        $process->stage_name = $this->getStageById($request->destination_stage_nr);
        
        if($request->destination_stage_nr == 1 || $request->destination_stage_nr == 2){
            $process->status = 'PENDING';
        }
        $process->save();

        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
