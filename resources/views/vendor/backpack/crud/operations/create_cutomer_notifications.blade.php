@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Customer Notifications' => url('') . '/admin/customer',
        'Add Customer Notifications' => false,
    ];
    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Customer Notifications</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Customer Notifications.</p>

        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="{{ url('') }}/admin/customer" class="d-print-none font-sm">
                    <span><i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></span>
                </a>
            </small>
        </p>

    </section>
@endsection

@section('content')
    <div class="row">
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
            <form method="post" action="{{ route('save-notifications') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body row">
                        <input type="hidden" name="customer_id" value="{{ $entry->id }}">
                        <div class="form-group col-md-12 required">
                            <label>Select all notifications apllicable</label>
                            <div class="row">
                                @foreach ($notifications as $notification)
                                    <label><input type="checkbox" name="notifications[]" value="{{ $notification->id }}"
                                            {{ in_array($notification->id, $customer_notifications) ? 'checked' : '' }}>
                                        {{ $notification->name }} </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-none" id="parentLoadedAssets">[]</div>
                <div id="saveActions" class="form-group my-3">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span>Submit</span>
                    </button>
                    <div class="btn-group" role="group">
                    </div>
                    <a href="{{ url($crud->route) }}" class="btn btn-default"><span class="la la-ban"></span>
                        &nbsp;Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection
