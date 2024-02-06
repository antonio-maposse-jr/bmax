<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StageProductionRequest;
use App\Models\StageProduction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Models\Process;
use App\Models\ProductionTask;
use App\Models\ReturnStage;
use App\Models\StageCashier;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\Auth;

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
        
        Widget::add()->type('script')->content('assets/js/file_control.js');
        Widget::add()->type('script')->content('assets/js/return_stage_popup.js');
        Widget::add()->type('script')->content('assets/js/production_validations.js');

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
       
        $stageProduction = StageProduction::firstOrNew(['process_id' => $request->process_id]);

        $stageProduction->process_id = $request->process_id;
        $stageProduction->user_id = Auth::user()->id;
        $stageProduction->status = "COMPLETED";

        if ($request->hasFile('other')) {
            $otherDocPath = $request->file('other')->store('documents', 'public');
            $stageProduction->other = $otherDocPath;
        }

        $stageProduction->save();

        ReturnStage::where('process_id', $request->process_id)->update(['message_status' => false]);

        $process = Process::find($request->process_id);
        $cashierStage = StageCashier::where('process_id', $request->process_id)->first();

        if($cashierStage->balance_to_be_paid != 0){
            $process->stage_id = 5;
            $process->stage_name = 'Credit Control';
            $process->save();
        }else{
            $process->stage_id = 6;
            $process->stage_name = 'Dispatch';
            $process->save();   
        }
    

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }

    public function updateTask(Request $request){
     $productionTask = ProductionTask::find($request->task_id);
        $productionTask->process_id = $request->process_id;
        $productionTask->user_id = Auth::user()->id;
        $productionTask->task_name = $request->task_name;
        $productionTask->sub_task_name = $request->sub_task_name;

        $updatedAt = $productionTask->updated_at;
        $timeDifferenceInMin = $updatedAt->diffInMinutes(now());

        if( $request->task_status == 'PROCESSING' && $productionTask->task_status == 'PAUSED'){
            $productionTask->total_iddle_time = $productionTask->total_iddle_time + $timeDifferenceInMin;
        }

        if( $request->task_status == 'PAUSED'){
            $productionTask->total_work_time = $productionTask->total_work_time + $timeDifferenceInMin;
        }

        if( $request->task_status == 'COMPLETED'){
            $productionTask->total_work_time = $productionTask->total_work_time + $timeDifferenceInMin;
        }

        $productionTask->task_status = $request->task_status;

        
        $productionTask->save();

        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect()->back();
      
    }

    public function assignTask(Request $request){
        $productionTask = ProductionTask::find($request->task_id);

        $productionTask->process_id = $request->process_id;
        $productionTask->user_id = Auth::user()->id;
        $productionTask->sub_task_name = $request->sub_task_name;
        $productionTask->total_allocated_sheets = $request->nr_sheets_allocated;

        $updatedAt = $productionTask->updated_at;
        $timeDifferenceInMin = $updatedAt->diffInMinutes(now());

        if( $productionTask->task_status == 'PAUSED'){
            $productionTask->total_iddle_time = $productionTask->total_iddle_time + $timeDifferenceInMin;
        }

        $productionTask->task_status = "PROCESSING";
        $productionTask->save();

        StageProduction::where('process_id', $request->process_id)->update(['total_unallocated_sheets' => $request->nr_sheets_unallocated]);
        
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect()->back();
    }

    public function assignPanels(Request $request){
        $productionTask = ProductionTask::find($request->task_id);

        $productionTask->process_id = $request->process_id;
        $productionTask->user_id = Auth::user()->id;
        $productionTask->sub_task_name = $request->sub_task_name;
        
        $productionTask->total_allocated_panels = $request->nr_panels_allocated;
        $updatedAt = $productionTask->updated_at;
        $timeDifferenceInMin = $updatedAt->diffInMinutes(now());

        if( $productionTask->task_status == 'PAUSED'){
            $productionTask->total_iddle_time = $productionTask->total_iddle_time + $timeDifferenceInMin;
        }

        $productionTask->task_status = "PROCESSING";
        $productionTask->save();

        StageProduction::where('process_id', $request->process_id)->update(['total_unallocated_panels' => $request->nr_panels_unallocated ]);
        
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect()->back();
    }


}
