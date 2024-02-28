<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\CustomerSystemNotification;
use App\Models\SystemNotification;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait NotificationsOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupNotificationsRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/notifications', [
            'as'        => $routeName.'.notifications',
            'uses'      => $controller.'@notifications',
            'operation' => 'notifications',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupNotificationsDefaults()
    {
        CRUD::allowAccess('notifications');

        CRUD::operation('notifications', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'notifications', 'view', 'crud::buttons.notifications');
            CRUD::addButton('line', 'notifications', 'view', 'crud::buttons.notifications');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function notifications()
    {
        CRUD::hasAccessOrFail('notifications');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Notifications '.$this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

        $customerNotifications = CustomerSystemNotification::where('customer_id', $this->crud->getCurrentEntry()->id)->pluck('system_notification_id')->toArray();
        $notifications = SystemNotification::all();
        $this->data['customer_notifications'] = $customerNotifications;
        $this->data['notifications'] = $notifications;
        // load the view
        return view('crud::operations.create_cutomer_notifications', $this->data);
    }
}