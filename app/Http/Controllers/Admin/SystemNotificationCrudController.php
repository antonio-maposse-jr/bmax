<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SystemNotificationRequest;
use App\Models\CustomerSystemNotification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class SystemNotificationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SystemNotificationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\SystemNotification::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/system-notification');
        CRUD::setEntityNameStrings('system notification', 'system notifications');
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
        CRUD::setValidation(SystemNotificationRequest::class);
        CRUD::field('name')->type('text')->wrapper([
            'class' => 'form-group col-sm-6'
        ]);
        CRUD::field([
            'name' => 'type',
            'type' => 'select_from_array',
            'options' => ['SMS' => 'SMS', 'Email' => 'Email', 'Push' => 'Push'],
            'allows_null' => false,
            'default' => 'one',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::field('code')->type('text')->wrapper([
            'class' => 'form-group col-sm-6'
        ]);;
        CRUD::field('description')->type('textarea')->wrapper([
            'class' => 'form-group col-sm-6'
        ]);;
        CRUD::field('active')->type('checkbox')
            ->wrapper([
                'class' => 'form-group col-sm-3'
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

    public function saveNotifications(Request $request) {
        // Validate the request if necessary
        $request->validate([
            'notifications' => 'array', // Assuming notifications are submitted as an array
            // Add any other validation rules as needed
        ]);
        

        // Get the notifications selected by the customer from the request
        $selectedNotifications = $request->input('notifications', []);

        // Delete existing notifications for this customer
        CustomerSystemNotification::where('customer_id', $request->customer_id)->delete();

        // Save the new notifications for this customer
        foreach ($selectedNotifications as $notificationId) {
            CustomerSystemNotification::create([
                'customer_id' => $request->customer_id,
                'system_notification_id' => $notificationId,
            ]);
        }

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        return redirect(url($this->crud->route));
    }
}
