@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Stage Cashiers' => url('') . '/admin/stage-cashier',
        'Add Stage Cashier' => false,
    ];
    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">stage dispatch control</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Add dispatch control.</p>

        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="{{ url('') }}/admin/stage-dispatch" class="d-print-none font-sm">
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
            <div class="nav-tabs-custom " id="cashier_tabs">
                <ul class="nav nav-tabs " role="tablist">
                    <li role="presentation" class="nav-item">
                        <a href="#tab_process" aria-controls="tab_process" role="tab" data-toggle="tab"
                            tab_name="process" data-name="process" data-bs-toggle="tab"
                            class="nav-link text-decoration-none active" aria-selected="true">Process Summary</a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#tab_cashier" aria-controls="tab_cashier" role="tab" data-toggle="tab"
                            tab_name="cashier" data-name="cashier" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Cashier</a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#tab_authorisation" aria-controls="tab_authorisation" role="tab" data-toggle="tab"
                            tab_name="authorisation" data-name="authorisation" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Authorisation</a>
                    </li>

                    <li role="presentation" class="nav-item">
                        <a href="#tab_production" aria-controls="tab_production" role="tab" data-toggle="tab"
                            tab_name="production" data-name="production" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Production</a>
                    </li>

                    <li role="presentation" class="nav-item">
                        <a href="#tab_credit_control" aria-controls="tab_credit_control" role="tab" data-toggle="tab"
                            tab_name="credit_control" data-name="credit_control" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Credit Control</a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#tab_dispatch" aria-controls="tab_dispatch" role="tab" data-toggle="tab"
                            tab_name="dispatch" data-name="dispatch" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Dispatch</a>
                    </li>

                </ul>

                <div class="tab-content ">
                    {{-- Process Resume --}}
                    @include('admin.tabs.tab_process')
                    {{-- End of process Resume --}}

                    {{-- Cashier Stage Data --}}
                    @include('admin.tabs.tab_cashier')
                    {{-- End of Cashier Stage Data --}}

                    {{-- Authorisation Stage Data --}}
                    @include('admin.tabs.tab_authorisation')
                    {{-- End of Authorisation Stage Data --}}

                    {{-- Production Stage data --}}
                    @include('admin.tabs.tab_production')
                    {{-- End of Production Stage data --}}

                    {{-- Credit Control Stage Data --}}
                    @include('admin.tabs.tab_credit_control')
                    {{-- End of Credit Control Data --}}

                    {{-- Dispatch Stage form --}}
                    <div role="tabpanel" class="tab-pane" id="tab_dispatch">
                        @if (Auth::user()->can('stage_dispatches_create'))
                            <form method="post" action="{{ route('submit-stage-dispatch-data') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-body row">
                                        <div class="form-group col-md-6 required">
                                            <label>Order ID</label>
                                            <input type="text" name="process_id" value=" {{ $entry->id }}"
                                                class="form-control" readonly>
                                        </div>

                                        <div class="form-group col-md-6 required">
                                            <label>Status</label>
                                            <select name="dispatch_status"
                                                value="{{ optional($dispatch_stage)->dispatch_status }}"
                                                id="dispatch_status" class="form-control" id="dispatch_status"
                                                onchange="partialDispatch()">
                                                <option value="Full Dispatch">Full Dispatch</option>
                                                <option value="Partial Dispatch">Partial Dispatch</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6 required">
                                            <label>Comment</label>
                                            <input type="text" value="{{ optional($dispatch_stage)->comment }}"
                                                name="comment" class="form-control">
                                        </div>

                                        <div class="form-group col-md-6 ">
                                            <label>Number of Panels</label>
                                            <input type="number" value="{{ optional($dispatch_stage)->nr_panels }}"
                                                name="nr_panels" id="nr_panels" class="form-control" disabled
                                                onchange="controlInputDataDispatch()">
                                        </div>

                                    </div>
                                </div>

                                <div class="d-none" id="parentLoadedAssets">[]</div>
                                <div id="saveActions" class="form-group my-3">
                                    <input type="hidden" name="_save_action" value="submit_complete_process">
                                    <button type="submit" class="btn btn-success" id="submit_btn">
                                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                        <span data-value="create_new_process">Complete Process</span>
                                    </button>

                                    <button type="button" onclick="openPopupDecline()" class="btn btn-danger">
                                        <span class="la la-window-close" role="presentation" aria-hidden="true"></span>
                                        &nbsp;
                                        <span data-value="create_new_process">Decline Process</span>
                                    </button>

                                    <button type="button" onclick="openPopup()" class="btn btn-info">
                                        <span class="la la-sync-alt" role="presentation" aria-hidden="true"></span>
                                        &nbsp;
                                        <span data-value="create_new_process">Return stages</span>
                                    </button>
                                    <div class="btn-group" role="group">
                                    </div>
                                    <a href="{{ url($crud->route) }}" class="btn btn-default"><span
                                            class="la la-ban"></span>
                                        &nbsp;Cancel</a>
                                </div>
                            </form>
                        @else
                            @include('admin.tabs.tab_unauthorized')
                        @endif

                    </div>
                    {{-- End of Dispatch Stage form --}}

                </div>
            </div>
        </div>

        <div class="overlay_rs" onclick="closePopup()"></div>

        {{-- Decline popup --}}
        <div class="popup_sheets" id="popup_decline">
            <div class="close-btn_rs" onclick="closePopupDecline()">X</div>
            <h2 style="color: #333; text-align: center;">Decline process</h2>
            <form action="{{ backpack_url('decline-process') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}" class="form-control" readonly>


                <label for="reason" class="popup_label">Reason for decline:</label>
                <select name="reason" id="reason_decline" class="popup_input">
                    <option value="Customer Cancelled Order">Customer Cancelled Order</option>
                    <option value="Process Duplicated">Process Duplicated</option>
                    <option value="Process Exceeds Limits">Process Exceeds Limits</option>
                    <option value="Process Eontains Excessive Inconsistencies">Process Eontains Excessive Inconsistencies
                    </option>
                    <option value="Other">Other</option>
                </select>

                <label for="comment" class="popup_label">Comment</label>
                <input type="text" class="popup_input" id="comment_decline" name="comment" required>

                <button type="submit" id="submit_panel_task_btn" class="btn btn-success">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="create_new_process">Submit</span>
                </button>
            </form>
        </div>
        {{-- End Decline popup --}}

        <div class="popup_rs">
            <div class="close-btn_rs" onclick="closePopup()">X</div>
            <h2 style="color: #333; text-align: center;">Return to Stage Form</h2>
            <form action="{{ route('return-stage') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}" class="form-control" readonly>
                <input type="hidden" name="origin_stage_nr" value="2" class="form-control" readonly>
                <input type="hidden" name="origin_stage_name" value="Authorisation Stage" class="form-control"
                    readonly>

                <label for="destination_stage_nr" class="popup_label">Select the destination stage:</label>
                <select id="destination_stage_nr" name="destination_stage_nr" class="popup_input" required>
                    <option value="1">Process Stage</option>
                    <option value="2">Cashier Stage</option>
                    <option value="3">Authorization Stage</option>
                    <option value="4">Production Stage</option>
                    <option value="5">Credit Control Stage</option>
                </select>

                <label for="reason" class="popup_label">Select the reason to return:</label>
                <select id="reason" name="reason" class="popup_input" required>
                    <option value="Incorrect Document">Incorrect Document</option>
                    <option value="Requires Special Approval">Requires Special Approval</option>
                    <option value="Quote & Invoice not Consistent">Quote & Invoice not Consistent</option>
                    <option value="Customer Changes">Customer Changes</option>
                    <option value="Other">Other</option>
                </select>

                <label for="comment" class="popup_label">Comment:</label>
                <input type="text" class="popup_input" id="comment" name="comment" required>

                <button type="submit" class="btn btn-success">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="create_new_process">Submit</span>
                </button>
            </form>
        </div>



    @endsection
