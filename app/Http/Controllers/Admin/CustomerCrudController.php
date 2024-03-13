<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WhatsappHelper;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\CustomerSystemNotification;
use App\Notifications\CashierMailNotification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

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
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \App\Http\Controllers\Admin\Operations\NotificationsOperation;
    use \App\Http\Controllers\Admin\Operations\CreateCustomerOperation;


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

        Widget::add()->type('style')->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css');
        Widget::add()->type('script')->content('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js');
        Widget::add()->type('script')->content('assets/js/phone_field.js');
        Widget::add()->type('script')->content('assets/css/phone_field.css');

        CRUD::setShowView('crud::operations.view_customer');
      
        $permissions = [
            'list' => 'customers_list',
            'createCustomer' => 'customers_create',
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
        $this->crud->column('name');
        $this->crud->column('phone');
        $this->crud->column('email');
        $this->crud->column('address');
        $this->crud->column('customerCategory')->label('Category');
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
            ],
            'attributes' => [
                'class'       => 'form-control some-class',
                'id'          => 'id_phone'
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

    public function createCustomerData(CustomerRequest $request){
        $customer = new Customer();

        $customer->name = $request->name;
        $customer->id_type = $request->id_type;
        $customer->id_number = $request->id_number;
        $customer->customer_category_id = $request->customer_category_id;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->tax_number = $request->tax_number;
        $customer->contact_person_name = $request->contact_person_name;
        $customer->contact_person_phone = $request->contact_person_phone;
        $customer->contact_person_email = $request->contact_person_email;
      
        if ($request->hasFile('id_document')) {
            $idDocPath = $request->file('id_document')->store('documents', 'public');
            $customer->id_document = $idDocPath;
        }

        if ($request->hasFile('company_reg_document')) {
            $companyRegDocPath = $request->file('company_reg_document')->store('documents', 'public');
            $customer->company_reg_document = $companyRegDocPath;
        }

        $customer->save();

        $selectedNotifications = $request->input('notifications', []);

        // Delete existing notifications for this customer
        CustomerSystemNotification::where('customer_id', $customer->id)->delete();

        // Save the new notifications for this customer
        foreach ($selectedNotifications as $notificationId) {
            CustomerSystemNotification::create([
                'customer_id' => $customer->id,
                'system_notification_id' => $notificationId,
            ]);
        }
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        return redirect(url($this->crud->route));
    }
    

    public function sendEmail()
    {
        // Assuming you have an order to send confirmation for
        $order = [
            'order_number' => '12345',
            'invoice_value' => '$1000',
            'amount_paid' => '$800',
            'sales_person' => 'John Doe',
            'customer_name' => 'Mariah Carey',
        ];

        $customerEmail = 'antonio.maposse.jr@gmail.com'; // Replace with the customer's email address

        // Send email using the OrderConfirmation Mailable class
        Notification::route('mail', $customerEmail)
        ->notify(new CashierMailNotification($order));


        return 'Email sent successfully';
    }

    public function sendWhatsapp(){
        $message= [
            "customer_name" => "Genius Nhavira",
            "order_value" => "23",
            "process_id" => "100",
        ];
        $messageSid = "HX7833d83cb0c6359169bc457524947099";
        $smsResult =  WhatsappHelper::sendWhatsapp("+258848299673", $message, $messageSid);

        if ($smsResult === 'SMS Sent Successfully.') {
            dd('success', 'SMS sent successfully.');
        } else {
            dd('error', 'Failed to send SMS.');
        }
    }
}
