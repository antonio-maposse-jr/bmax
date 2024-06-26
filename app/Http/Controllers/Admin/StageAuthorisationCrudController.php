<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StageAuthorisationsRequest;
use App\Models\StageAuthorisation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use App\Models\Process;
use App\Models\ReturnStage;
use Illuminate\Support\Facades\Auth;

/**
 * Class StageAuthorisationsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StageAuthorisationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\ProcessAuthorizationStageOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);
        CRUD::setCreateView('crud::operations.create_stage_authorization');

        CRUD::setRoute(config('backpack.base.route_prefix') . '/stage-authorisations');
        CRUD::setEntityNameStrings('stage authorisations', 'stage authorisations');

        Widget::add()->type('script')->content('assets/js/file_control.js');
        Widget::add()->type('script')->content('assets/js/stage_config.js');
        Widget::add()->type('script')->content('assets/js/return_stage_popup.js');
        Widget::add()->type('style')->content('assets/css/return_stage_popup.css');
        Widget::add()->type('script')->content('assets/js/production_validations.js');
        Widget::add()->type('style')->content('assets/css/other.css');

        $permissions = [
            'list' => 'stage_authorisations_list',
            'processAuthorizationStage' => 'stage_authorisations_show',
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
        CRUD::addClause('where', 'stage_id', '3');
        CRUD::addClause('where', 'status', 'PROCESSING');
        $this->crud->column('id');
        $this->crud->column('customer_id');
        $this->crud->column('date_required');
        $this->crud->column('priority_level');
        $this->crud->column('stage_name');
        $this->crud->column('order_value');
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'custom_html',
            'value' => '<span class="badge badge-pill badge-info">PROCESSING</span>'
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
        CRUD::setValidation(StageAuthorisationsRequest::class);
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

    public function createStageAuthorisation(StageAuthorisationsRequest $request)
    {
        if (!backpack_user()->can('stage_authorisations_create', 'backpack')) {
            abort(403, 'Unauthorized access - you do not have the necessary permissions to see this page.');
        }

        $stageAuthorization = StageAuthorisation::firstOrNew(['process_id' => $request->process_id]);
        $stageAuthorization->process_id = $request->process_id;
        $stageAuthorization->comment = $request->comment;
        $stageAuthorization->decision = $request->decision;
        $stageAuthorization->comments = $request->comments;
        $stageAuthorization->user_id = Auth::user()->id;

        if ($request->hasFile('other_documents')) {
            $otherDocPath = $request->file('other_documents')->store('documents', 'public');
            $stageAuthorization->other_documents = $otherDocPath;
        }

        $stageAuthorization->save();
        ReturnStage::where('process_id', $request->process_id)->update(['message_status' => false]);

        $process = Process::find($request->process_id);
        $process->stage_id = 4;
        $process->stage_name = 'Production';
        $process->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
}
