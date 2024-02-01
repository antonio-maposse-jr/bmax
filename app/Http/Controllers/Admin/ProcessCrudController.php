<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProcessRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use App\Models\Process;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


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

        Widget::add()->type('style')->content('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
        Widget::add()->type('script')->content('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js');
        Widget::add()->type('script')->content('assets/js/process.js');
        Widget::add()->type('style')->content('assets/css/select2_custom.css');
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
        CRUD::setValidation(ProcessRequest::class);
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
            'tab' => 'Form'
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

        CRUD::field([
            'name' => 'colors',
            'type'      => 'select_from_array',
            'options' => [
                'Red' => 'Red', 'Blue' => 'Blue',
                'Green' => 'Green', 'Yellow' => 'Yellow',
                'Orange' => 'Orange', 'Purple' => 'Purple',
                'Cyan' => 'Cyan', 'Magenta' => 'Magenta',
                'Lime' => 'Lime', 'Pink' => 'Pink',
                'Teal' => 'Teal', 'Brown' => 'Brown',
                'Maroon' => 'Maroon', 'Navy' => 'Navy',
                'Olive' => 'Olive',
                'Silver' => 'Silver',
                'Black' => 'Black',
                'White' => 'White',
            ],
            'allows_null' => false,
            'default' => 'one',
            'wrapper' => [
                'class' => 'form-group col-md-12'
            ],
            'attributes' => [
                'multiple'       => 'true',
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

    public function createNewProcess(Request $request)
    {
        CRUD::setValidation(ProcessRequest::class);
        //Basic Fields Process
        $process = new Process();
        $process->customer_id = $request->customer_id;
        $process->user_id = $request->user_id;
        $process->product_id = $request->product_id;
        $process->nr_sheets = $request->nr_sheets;
        $process->nr_panels = $request->nr_panels;
        $process->order_value = $request->order_value;
        $process->estimated_process_time = $request->estimated_process_time;
        $process->date_required = $request->date_required;
        $process->priority_level = $request->priority_level;
        $process->job_reference = $request->job_reference;
        $process->order_confirmation = $request->order_confirmation;
        //End Basic Fields Process

        //Process Colors
        $colors = $request->colors;
        if (is_array($colors)) {
            $resultString = implode(', ', $colors);
            $process->colors = $resultString;
        } else {
            $process->colors = '';
        }

   
        //End process colors

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

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

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

        $process->save();

        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
