@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Stage Authorisations' => url('') . '/admin/stage-authorisations',
        'Add Stage Authorisations' => false,
    ];
    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">stage authorisation</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Add stage authorisation.</p>

        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="{{ url('') }}/admin/stage-authorisations" class="d-print-none font-sm">
                    <span><i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></span>
                </a>
            </small>
        </p>

    </section>
@endsection

@section('content')

    @foreach ($return_stages as $returnStage)
        <div class="notification-bar">
            <strong>Process returned to {{ $returnStage->destination_stage_name }}</strong> by
            <strong>{{ $returnStage->user->name }}</strong>. The reason is <strong>{{ $returnStage->reason }}</strong> with
            the following description <strong>{{ $returnStage->comment }}</strong>
            <span class="close-btn-notfication-rs" onclick="closeNotification()">×</span>
        </div>
    @endforeach
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

                </ul>

                <div class="tab-content ">

                    {{-- Process Resume --}}
                    @include('admin.tabs.tab_process')
                    {{-- End of process Resume --}}

                    {{-- Cashier Stage --}}
                    @include('admin.tabs.tab_cashier')
                    {{-- End of Cashier Stage --}}

                    <div role="tabpanel" class="tab-pane" id="tab_authorisation">
                        @if (Auth::user()->can('stage_authorisations_create'))
                            <form method="post" action="{{ route('submit-stage-authorisation-data') }}"
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
                                            <label>DECISION</label>
                                            <select name="decision" id="decision"
                                                value="{{ optional($authorisation_stage)->decision }}" class="form-control"
                                                onchange="specialConditionsAuthorization()">
                                                <option value=""></option>
                                                <option value="APPROVED">APPROVED</option>
                                                <option value="APPROVED WITH CONDITIONS">APPROVED WITH CONDITIONS</option>
                                                <option value="REJECTED">REJECTED</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 required">
                                            <label>Comment</label>
                                            <input type="text" value="{{ optional($authorisation_stage)->comment }}"
                                                name="comment" class="form-control">
                                        </div>

                                        <div class="form-group col-md-12 ">
                                            <label>Special conditions list</label>
                                            <textarea name="comments" onchange="controlInputDataAuth()" class="form-control" on id="auth_special_conditions"
                                                disabled>{{ optional($authorisation_stage)->comments }}</textarea>
                                        </div>

                                        <hr>

                                        <div class="form-group col-md-6 required">
                                            <div id="otherDocContainer"
                                                style="display: {{ isset($authorisation_stage->other_documents) ? 'none' : 'block' }}">
                                                <label>Other</label>
                                                <input type="file" name="other_documents" id="other_documents"
                                                    class="form-control">
                                            </div>

                                            <div class="existing-file"
                                                style="display: {{ isset($authorisation_stage->other_documents) ? 'block' : 'none' }}"
                                                id="fileDisplayOtherDoc">
                                                @if (isset($authorisation_stage->other_documents))
                                                    <a href="{{ Storage::url($authorisation_stage->other_documents) }}"
                                                        target="_blank">Download/View Other</a>
                                                    <button type="button"
                                                        onclick="removeFile('other_documents', 'fileDisplayOtherDoc', 'otherContainer')"
                                                        class="file_clear_button btn btn-light btn-sm float-right"
                                                        title="Clear file"
                                                        data-filename="{{ $authorisation_stage->other }}"><i
                                                            class="la la-remove"></i></button>
                                                    <div class="clearfix"></div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="d-none" id="parentLoadedAssets">[]</div>
                                <div id="saveActions" class="form-group my-3">
                                    <input type="hidden" name="_save_action" value="submit_authorisation_stage">
                                    <button type="submit" class="btn btn-success" id="submit_btn">
                                        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                        <span data-value="create_new_process">Submit</span>
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
                </div>


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

            <button type="button" onclick="openPopupDecline()" class="btn btn-danger">
                <span class="la la-window-close" role="presentation" aria-hidden="true"></span>
                &nbsp;
                <span data-value="create_new_process">Decline Process</span>
            </button>

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
            <input type="hidden" name="origin_stage_name" value="Authorisation Stage" class="form-control" readonly>

            <label for="destination_stage_nr" class="popup_label">Select the destination stage:</label>
            <select id="destination_stage_nr" name="destination_stage_nr" class="popup_input" required>
                <option value="1">Sales Stage</option>
                <option value="2">Cashier Stage</option>
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
