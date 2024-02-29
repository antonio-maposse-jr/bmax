@if ($crud->hasAccess('createCustomer'))
    <a href="{{ url($crud->route.'/create-customer') }}" class="btn btn-primary" data-style="zoom-in">
        <span><i class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span>
    </a>
@endif