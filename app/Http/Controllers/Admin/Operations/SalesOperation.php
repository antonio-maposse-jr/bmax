<?php

namespace App\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait SalesOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupSalesRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/sales', [
            'as'        => $routeName.'.sales',
            'uses'      => $controller.'@sales',
            'operation' => 'sales',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupSalesDefaults()
    {
        CRUD::allowAccess('sales');

        CRUD::operation('sales', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'sales', 'view', 'crud::buttons.sales');
             CRUD::addButton('line', 'sales', 'view', 'crud::buttons.sales');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function sales()
    {
        CRUD::hasAccessOrFail('sales');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Sales '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();
        // load the view
        return view('crud::operations.sales', $this->data);
    }
}