@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        $crud->entity_name_plural => url($crud->route),
        'Create Customer' => false,
    ];
    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">{!! $crud->getSubheading() ?? trans('backpack::crud.add') . ' ' . $crud->entity_name !!}.</p>
        @if ($crud->hasAccess('list'))
            <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <span><i
                                class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                            {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></span>
                    </a>
                </small>
            </p>
        @endif
    </section>
@endsection

@section('content')
    <div class="container-fluid animated fadeIn">
        <div class="row" bp-section="crud-operation-create">
            <div class="col-md-12 bold-labels">
                @if ($errors->any())
                <div class="alert alert-danger pb-0">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                        <li><i class="la la-info-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="post" action="{{ route('create-customer-with-notifications') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group col-md-6 required">
                                <label>Name</label>
                                <input type="text" name="name" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Category</label>
                                <select name="customer_category_id" class="form-control">
                                    @foreach ($customer_categories as $customer_category)
                                        <option value="{{ $customer_category->id }}">{{ $customer_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Id type</label>
                                <select name="id_type" class="form-control">
                                    <option value="id">National ID</option>
                                    <option value="passport">Passport</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Id number</label>
                                <input type="text" name="id_number" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Phone</label>
                                <input type="text" name="phone" id="id_phone" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Address</label>
                                <input type="text" name="address" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Tax number</label>
                                <input type="text" name="tax_number" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Contact person name</label>
                                <input type="text" name="contact_person_name" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6 required">
                                <label>Contact person phone</label>
                                <input type="text" name="contact_person_phone" value="" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Contact person email</label>
                                <input type="text" name="contact_person_email" value="" class="form-control">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Id document</label>
                                <input type="file" name="id_document" class="form-control">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Company reg document</label>
                                <input type="file" name="company_reg_document" class="form-control">
                            </div>
                            <hr>

                            <label>Select all notifications apllicable</label>
                            <div class="row">
                                @foreach ($notifications as $notification)
                                    <div class="col-sm-4">
                                        <label><input type="checkbox" name="notifications[]" value="{{ $notification->id }}">
                                            {{ $notification->name }} </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-none" id="parentLoadedAssets">[]
                    </div>
                    <div id="saveActions" class="form-group my-3">
                        <input type="hidden" name="save_action" value="save_and_preview">
                        <button type="submit" class="btn btn-success">
                            <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span data-value="create_new_process">Create Customer</span>
                        </button>
                        <a href="{{ url($crud->route) }}" class="btn btn-secondary text-decoration-none"><span
                                class="la la-ban"></span>
                            &nbsp;Cancel</a>

                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
