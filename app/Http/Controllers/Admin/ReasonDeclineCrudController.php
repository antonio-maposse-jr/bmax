<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ReasonDeclineRequest;
use App\Models\Process;
use App\Models\ReasonDecline;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class ReasonDeclineCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReasonDeclineCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \App\Http\Controllers\Admin\Operations\ViewProcessOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Process::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/reason-decline');
        CRUD::setEntityNameStrings('reason decline', 'reason declines');

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
        CRUD::addClause('where', 'status', 'DECLINED');

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
        CRUD::setValidation(ReasonDeclineRequest::class);
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

    public function declineProcess(Request $request){
        $reason = new ReasonDecline();
        $reason->process_id = $request->process_id;
        $reason->user_id = Auth::user()->id;
        $reason->reason = $request->reason;
        $reason->comment = $request->comment;
        $reason->save();

        Process::where('id', $request->process_id)->update(['status' => 'DECLINED']);

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        return redirect('admin/process');
    }
}
