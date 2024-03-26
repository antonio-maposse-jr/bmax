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
            <form method="post" action="{{ route('submit-sales-stage') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-md-6 required">
                            <label>Customer </label>
                            <input value="{{ $entry->customer->name }}" class="form-control" disabled>
                            <input name="process_id" value="{{$entry->id }}" type="hidden">
                            <input name="user_id" value="{{ Auth::user()->id }}" type="hidden">
                            <input name="customer_id" value="{{ $entry->customer_id }}" type="hidden">
                        </div>
                        <div class="form-group col-md-6 required">
                            <label>Key Products </label>
                            <select id="productSelect" class="form-control" name="key_products[]" multiple>
                                @foreach ($entry->products as $keyProduct)
                                    <option value="{{ $keyProduct->product->id }}" selected>{{ $keyProduct->product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 required">
                            <label>Number of Sheets</label>
                            <input type="number" value="{{ $entry->nr_sheets }}" name="nr_sheets" class="form-control">
                        </div>
                        <div class="form-group col-md-6 required">
                            <label>Number of Panels</label>
                            <input type="number" value="{{ $entry->nr_panels }}" name="nr_panels" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Order value</label>
                            <input type="number" value="{{ $entry->order_value }}" name="order_value" class="form-control"
                                step="0.01" placeholder="0.00" min="0.01">
                        </div>
                        <div class="form-group col-md-6 required">
                            <label>Estimated process time (hours)</label>
                            <input type="number" value="{{ $entry->estimated_process_time }}"
                                name="estimated_process_time" class="form-control">
                        </div>
                        <div class="form-group col-md-6 required">
                            <label>Date required</label>
                            <input type="date" value="{{ $entry->date_required }}" name="date_required"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-6 required">
                            <label>Priority level</label>
                            <select name="priority_level" id="priority_level" class="form-control">
                                <option>Please Select</option>
                                <option value="Low" {{ $entry->priority_level == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $entry->priority_level == 'Medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="High" {{ $entry->priority_level == 'High' ? 'selected' : '' }}>High
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-6 required">
                            <label>Order confirmation</label>
                            <select name="order_confirmation" id="order_confirmation" class="form-control">
                                <option>Please Select</option>
                                <option value="Call" {{ $entry->order_confirmation == 'Call' ? 'selected' : '' }}>Call
                                </option>
                                <option value="Email" {{ $entry->order_confirmation == 'Email' ? 'selected' : '' }}>Email
                                </option>
                                <option value="In person"
                                    {{ $entry->order_confirmation == 'In person' ? 'selected' : '' }}>In person</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 required">
                            <label>Select all Apllicable</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->cutting ? 'checked' : '' }} name="cutting">
                                        Cutting </label>
                                </div>

                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->edging ? 'checked' : '' }} name="edging">
                                        Edging </label>
                                </div>
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->cnc_machining ? 'checked' : '' }}
                                            name="cnc_machining"> CNC Machining </label>
                                </div>
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->grooving ? 'checked' : '' }} name="grooving">
                                        Grooving </label>
                                </div>
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->hinge_boring ? 'checked' : '' }}
                                            name="hinge_boring"> Hinge Boring </label>
                                </div>
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->wrapping ? 'checked' : '' }} name="wrapping">
                                        Wrapping </label>
                                </div>
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->sanding ? 'checked' : '' }} name="sanding">
                                        Sanding </label>
                                </div>
                                <div class="col-sm-3">
                                    <label><input type="checkbox" {{ $entry->hardware ? 'checked' : '' }}
                                            name="hardware">
                                        Hardware </label>
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-md-12">
                            <label>Job reference</label>
                            <textarea name="job_reference" class="form-control">{{ optional($entry)->job_reference }}</textarea>
                        </div>
                        <hr>

                        <div class="form-group col-md-6 ">
                            <div id="jobLayoutContainer"
                                style="display: {{ isset($entry->job_layout) ? 'none' : 'block' }}">
                                <label>Job Layout <span style="color: #e25b6a">*</span></label>
                                <input type="file" name="job_layout" id="jobLayout" class="form-control">
                            </div>

                            <div class="existing-file"
                                style="display: {{ isset($entry->job_layout) ? 'block' : 'none' }}"
                                id="fileDisplayJobLayout">
                                @if (isset($entry->job_layout))
                                    <a href="{{ Storage::url($entry->job_layout) }}" target="_blank">Download/View
                                        Job Layout</a>
                                    <button type="button"
                                        onclick="removeFile('jobLayout', 'fileDisplayJobLayout', 'jobLayoutContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->job_layout }}"><i class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 ">
                            <div id="cuttingListContainer"
                                style="display: {{ isset($entry->cutting_list) ? 'none' : 'block' }}">
                                <label>Cutting List <span style="color: #e25b6a">*</span></label>
                                <input type="file" name="cutting_list" id="cuttingList" class="form-control">
                            </div>

                            <div class="existing-file"
                                style="display: {{ isset($entry->cutting_list) ? 'block' : 'none' }}"
                                id="fileDisplayCuttingList">
                                @if (isset($entry->cutting_list))
                                    <a href="{{ Storage::url($entry->cutting_list) }}" target="_blank">Download/View
                                        Cutting List</a>
                                    <button type="button"
                                        onclick="removeFile('cuttingList', 'fileDisplayCuttingList', 'cuttingListContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->cutting_list }}"><i class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 ">
                            <div id="quoteContainer" style="display: {{ isset($entry->quote) ? 'none' : 'block' }}">
                                <label>Quote <span style="color: #e25b6a">*</span></label>
                                <input type="file" name="quote" id="quoteFile" class="form-control">
                            </div>

                            <div class="existing-file" style="display: {{ isset($entry->quote) ? 'block' : 'none' }}"
                                id="fileDisplayQuote">
                                @if (isset($entry->cutting_list))
                                    <a href="{{ Storage::url($entry->quote) }}" target="_blank">Download/View Quote</a>
                                    <button type="button"
                                        onclick="removeFile('quoteFile', 'fileDisplayQuote', 'quoteContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->quote }}"><i class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 ">
                            <div id="confirmationCallRecordContainer"
                                style="display: {{ isset($entry->confirmation_call_record) ? 'none' : 'block' }}">
                                <label>Confirmation Call Record <span style="color: #e25b6a">*</span></label>
                                <input type="file" name="confirmation_call_record" id="confirmationCallRecord"
                                    class="form-control">
                            </div>

                            <div class="existing-file"
                                style="display: {{ isset($entry->confirmation_call_record) ? 'block' : 'none' }}"
                                id="fileDisplayConfirmationCallRecord">
                                @if (isset($entry->confirmation_call_record))
                                    <a href="{{ Storage::url($entry->confirmation_call_record) }}"
                                        target="_blank">Download/View Confirmation Call Record</a>
                                    <button type="button"
                                        onclick="removeFile('confirmationCallRecord', 'fileDisplayConfirmationCallRecord', 'confirmationCallRecordContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->confirmation_call_record }}"><i
                                            class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 ">
                            <div id="signedConfirmationContainer"
                                style="display: {{ isset($entry->signed_confirmation) ? 'none' : 'block' }}">
                                <label>Signed Confirmation <span style="color: #e25b6a">*</span></label>
                                <input type="file" name="signed_confirmation" id="signedConfirmation"
                                    class="form-control">
                            </div>
                            <div class="existing-file"
                                style="display: {{ isset($entry->signed_confirmation) ? 'block' : 'none' }}"
                                id="fileDisplaySignedConfirmation">
                                @if (isset($entry->signed_confirmation))
                                    <a href="{{ Storage::url($entry->signed_confirmation) }}"
                                        target="_blank">Download/View Signed Confirmation</a>
                                    <button type="button"
                                        onclick="removeFile('signedConfirmation', 'fileDisplaySignedConfirmation', 'signedConfirmationContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->signed_confirmation }}"><i
                                            class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6 ">
                            <div id="customCutLisContainer"
                                style="display: {{ isset($entry->custom_cutting_list) ? 'none' : 'block' }}">
                                <label>Customer Cutting List <span style="color: #e25b6a">*</span></label>
                                <input type="file" name="custom_cutting_list" id="customCuttingList"
                                    class="form-control">
                            </div>
                            <div class="existing-file"
                                style="display: {{ isset($entry->custom_cutting_list) ? 'block' : 'none' }}"
                                id="fileDisplaycustomCutList">
                                @if (isset($entry->custom_cutting_list))
                                    <a href="{{ Storage::url($entry->custom_cutting_list) }}"
                                        target="_blank">Download/View Customer Cutting List</a>
                                    <button type="button"
                                        onclick="removeFile('customCuttingList', 'fileDisplaycustomCutList', 'customCutLisContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->custom_cutting_list }}"><i
                                            class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div id="otherContainer"
                                style="display: {{ isset($entry->other_document) ? 'none' : 'block' }}">
                                <label>Other document</label>
                                <input type="file" name="other_document" id="otherDocument" class="form-control">
                            </div>

                            <div class="existing-file"
                                style="display: {{ isset($entry->other_document) ? 'block' : 'none' }}"
                                id="fileDisplayOther">
                                @if (isset($entry->other_document))
                                    <a href="{{ Storage::url($entry->other_document) }}" target="_blank">Download/View
                                        Other document</a>
                                    <button type="button"
                                        onclick="removeFile('otherDocument', 'fileDisplayOther', 'otherContainer')"
                                        class="file_clear_button btn btn-light btn-sm float-right" title="Clear file"
                                        data-filename="{{ $entry->other_document }}"><i
                                            class="la la-remove"></i></button>
                                    <div class="clearfix"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-none" id="parentLoadedAssets">[]</div>
                <div id="saveActions" class="form-group my-3">
                    <input type="hidden" name="_save_action" value="create_new_process">
                    <button type="submit" class="btn btn-success">
                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span data-value="create_new_process">Submit for Cashier</span>
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
