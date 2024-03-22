@extends(backpack_view('blank'))

@php
$defaultBreadcrumbs = [
trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
$crud->entity_name_plural => url($crud->route),
'Email' => false,
];
// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
<section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</p>
        @if ($crud->hasAccess('list'))
            <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <span><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></span>
                    </a>
                </small>
            </p>
        @endif
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
        <form method="post" action="{{route('create-new-process')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-md-6 required">
                        <label>Customer </label>
                        <select id="customerSelect" class="form-control" name="customer_id">
                        </select>
                        <input name="user_id" value="{{Auth::user()->id}}" type="hidden">
                    </div>
                    <div class="form-group col-md-6 required">
                        <label>Key Products </label>
                        <select id="productSelect" class="form-control"  value="{{ old('key_products[]') }}" name="key_products[]" multiple>
                        </select>
                    </div>
                    <div class="form-group col-md-6 required">
                        <label>Number of Sheets</label>
                        <input type="number"  value="{{ old('nr_sheets') }}" name="nr_sheets" class="form-control">
                    </div>
                    <div class="form-group col-md-6 required">
                        <label>Number of Panels</label>
                        <input type="number"  value="{{ old('nr_panels') }}" name="nr_panels" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Order value</label>
                        <input type="number" value="{{ old('order_value') }}" name="order_value" class="form-control" step="0.01" placeholder="0.00" min="0.01">
                    </div>
                    <div class="form-group col-md-6 required">
                        <label>Estimated process time (hours)</label>
                        <input type="number"  value="{{ old('estimated_process_time') }}" name="estimated_process_time" class="form-control">
                    </div>
                    <div class="form-group col-md-6 required">
                        <label>Date required</label>
                        <input type="date" value="{{ old('date_required') }}" name="date_required" class="form-control">
                    </div>
                    <div class="form-group col-md-6 required">
                        <label>Priority level</label>
                        <select name="priority_level" id="priority_level" class="form-control">
                            <option>Please Select</option>
                            <option value="Low" {{ old('priority_level') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority_level') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6 required">
                        <label>Order confirmation</label>
                        <select name="order_confirmation" value="{{ old('order_confirmation') }}" id="order_confirmation" class="form-control">
                            <option>Please Select</option>
                            <option value="Call" {{ old('order_confirmation') == 'Call' ? 'selected' : '' }}>Call</option>
                            <option value="Email" {{ old('order_confirmation') == 'Email' ? 'selected' : '' }}>Email</option>
                            <option value="In person" {{ old('order_confirmation') == 'In person' ? 'selected' : '' }}>In person</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 required">
                        <label>Select all Apllicable</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('cutting') ? 'checked' : '' }} name="cutting"> Cutting </label>
                            </div>

                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('edging') ? 'checked' : '' }} name="edging"> Edging </label>
                            </div>
                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('cnc_machining') ? 'checked' : '' }} name="cnc_machining"> CNC Machining </label>
                            </div>
                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('grooving') ? 'checked' : '' }} name="grooving"> Grooving </label>
                            </div>
                            <div class="col-sm-3">
                                <label><input type="checkbox" {{ old('hinge_boring') ? 'checked' : '' }} name="hinge_boring"> Hinge Boring </label>
                            </div>
                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('wrapping') ? 'checked' : '' }} name="wrapping"> Wrapping </label>
                            </div>
                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('sanding') ? 'checked' : '' }} name="sanding"> Sanding </label>
                            </div>
                            <div class="col-sm-3">
                                <label><input type="checkbox"  {{ old('hardware') ? 'checked' : '' }} name="hardware"> Hardware </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group col-md-12">
                        <label>Job reference</label>
                        <textarea name="job_reference" value="{{ old('job_reference') }}" class="form-control"></textarea>
                    </div>
                    <hr>

                    <div class="form-group col-md-6 required">
                        <label>Job Layout</label>
                        <input type="file" name="job_layout" value="{{ old('job_layout') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-6 required">
                        <label>Cutting List</label>
                        <input type="file" name="cutting_list" value="{{ old('cutting_list') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-6 required">
                        <label>Quote</label>
                        <input type="file" name="quote" value="{{ old('quote') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-6" id="confirmation_call_record_group">
                        <label>Confirmation call record</label>
                        <input type="file" name="confirmation_call_record" value="{{ old('confirmation_call_record') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-6" id="signed_confirmation_group">
                        <label>Signed confirmation</label>
                        <input type="file" name="signed_confirmation" value="{{ old('signed_confirmation') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-6 required">
                        <label>Customer cutting list</label>
                        <input type="file" name="custom_cutting_list" value="{{ old('custom_cutting_list') }}" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Other document</label>
                        <input type="file" name="other_document" value="{{ old('other_document') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-none" id="parentLoadedAssets">[]</div>
            <div id="saveActions" class="form-group my-3">
                <input type="hidden" name="_save_action" value="create_new_process">
                <button type="submit" class="btn btn-success">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="create_new_process">Create process</span>
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