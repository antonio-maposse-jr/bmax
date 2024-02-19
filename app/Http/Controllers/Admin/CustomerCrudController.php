<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;


/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');

        $permissions = [
            'list' => 'customers_list',
            'create' => 'customers_create',
            'update' => 'customers_update',
            'delete' => 'customers_delete',
            'show' => 'customers_show',
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
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field([
            'name' => 'name',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::addField([
            'label' => 'Category',
            'type' => 'select',
            'name' => 'customer_category_id',
            'entity' => 'customerCategory',
            'model' => 'App\Models\CustomerCategory',
            'ajax'          => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::field([
            'name' => 'id_type',
            'type' => 'select_from_array',
            'options' => ['id' => 'National ID', 'passport' => 'Passport'],
            'allows_null' => false,
            'default' => 'one',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'id_number',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'phone',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'email',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::field([
            'name' => 'address',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'tax_number',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'contact_person_name',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'contact_person_phone',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::field([
            'name' => 'contact_person_email',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::field('id_document')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'uploads', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ]);

        CRUD::field('company_reg_document')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'uploads', // the path inside the disk where file will be stored
            ])->wrapper([
                'class' => 'form-group col-sm-6'
            ]);
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
    public function getCustomers(Request $request)
    {
        $searchTerm = $request->input('q');
        $customers = Customer::where('name', 'like', '%' . $searchTerm . '%')->get(['id', 'name']);
    
        return response()->json($customers);
    }
}
