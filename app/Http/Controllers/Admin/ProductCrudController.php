<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;


/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column([
            'name'  => 'name',
            'type'  => 'text'
        ]);

        CRUD::column([
            'name'  => 'image',
            'type'  => 'image',
            'disk' => 'public',
        ]);

        CRUD::column([
            'name'  => 'description',
            'type'  => 'textarea'
        ]);

        CRUD::column([
            'name'  => 'price',
            'type'  => 'number'
        ]);

        CRUD::column([
            'name'  => 'unit',
            'type'  => 'text'
        ]);

        CRUD::column([
            'name' => 'category.name', 
            'label' => 'Category',
            'type' => 'text'
        ]);
        CRUD::column([
            'name' => 'subcategory.name',
            'label' => 'Sub Category',
            'type' => 'text'
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
        CRUD::setValidation(ProductRequest::class);
        CRUD::field('name')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ]);
        CRUD::field('price')->type('number')
            ->wrapper([
                'class' => 'form-group col-sm-6'
            ]);
        CRUD::field([
            'name' => 'unit',
            'type' => 'select_from_array',
            'options' => ['kgs' => 'Kilograms', 'units' => 'Units', 'm' => 'Meters', 'sqm' => 'Square metres', 'Box' => 'Boxes', 'Packs' => 'Packets', 'L' => 'Litres'],
            'allows_null' => false,
            'default' => 'one',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::addField([
            'label' => 'Category',
            'type' => 'select',
            'name' => 'category_id', // This name should match the relationship method in your Product model
            'entity' => 'Category',
            'model' => 'App\Models\Category',
            'ajax'          => true,
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        CRUD::addField([
            'label' => 'Subcategory',
            'type' => 'select',
            'name' => 'subcategory_id', // This name should match the relationship method in your Product model
            'entity' => 'Subcategory',
            'model' => 'App\Models\Subcategory',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        CRUD::field('description')->type('textarea');
        CRUD::field('image')
            ->type('upload')
            ->withFiles([
                'disk' => 'public', // the disk where file will be stored
                'path' => 'uploads', // the path inside the disk where file will be stored
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

    protected function setupShowOperation()
    {
        CRUD::column([
            'name'  => 'name',
            'type'  => 'text'
        ]);

        CRUD::column([
            'name'  => 'image',
            'type'  => 'image',
            'disk' => 'public',
        ]);

        CRUD::column([
            'name'  => 'description',
            'type'  => 'textarea'
        ]);

        CRUD::column([
            'name'  => 'price',
            'type'  => 'number'
        ]);

        CRUD::column([
            'name'  => 'unit',
            'type'  => 'text'
        ]);

        CRUD::column([
            'name' => 'category.name', // Assuming 'category' is the name of the relationship
            'label' => 'Category',
            'type' => 'text'
        ]);
        CRUD::column([
            'name' => 'subcategory.name', // Assuming 'category' is the name of the relationship
            'label' => 'Sub Category',
            'type' => 'text'
        ]);
    }

    public function getProducts(Request $request)
    {
        $searchTerm = $request->input('q');
        $customers = Product::where('name', 'like', '%' . $searchTerm . '%')->get(['id', 'name']);

        return response()->json($customers);
    }
}
