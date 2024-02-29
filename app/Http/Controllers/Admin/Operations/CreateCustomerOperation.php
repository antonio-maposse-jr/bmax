<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\CustomerCategory;
use App\Models\SystemNotification;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait CreateCustomerOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCreateCustomerRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/create-customer', [
            'as'        => $routeName.'.createCustomer',
            'uses'      => $controller.'@createCustomer',
            'operation' => 'createCustomer',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCreateCustomerDefaults()
    {
        CRUD::allowAccess('createCustomer');

        CRUD::operation('createCustomer', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
             CRUD::addButton('top', 'create_customer', 'view', 'crud::buttons.create_customer');
            // CRUD::addButton('line', 'create_customer', 'view', 'crud::buttons.create_customer');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function createCustomer()
    {
        CRUD::hasAccessOrFail('createCustomer');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Create Customer '.$this->crud->entity_name;
        $notifications = SystemNotification::all();
        $this->data['notifications'] = $notifications;
        $cutomerCategories = CustomerCategory::all();
        $this->data['customer_categories'] = $cutomerCategories;

        // load the view
        return view('crud::operations.create_customer', $this->data);
    }
}