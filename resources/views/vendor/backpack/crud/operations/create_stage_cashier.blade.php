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
        <h1 class="text-capitalize mb-0" bp-section="page-heading">stage cashiers</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Add stage cashier.</p>

        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="{{ url('') }}/admin/stage-cashier" class="d-print-none font-sm">
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

                </ul>

                <div class="tab-content ">
                    {{-- Process Resume --}}
                    @include('admin.tabs.tab_process')
                    {{-- End of process Resume --}}
                    <div role="tabpanel" class="tab-pane" id="tab_cashier">
                        @if (Auth::user()->can('stage_cashiers_create'))
                            <form method="post" action="{{ route('submit-stage-cashier-data') }}"
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
                                            <label>Invoice Reference</label>
                                            <input type="text" value="{{ optional($cashier_stage)->invoice_reference }}"
                                                name="invoice_reference" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6" id="reciept_ref_group">
                                            <label>Reciept Reference</label>
                                            <input type="text" name="reciept_reference"
                                                value="{{ optional($cashier_stage)->reciept_reference }}"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-6 required">
                                            <label>Invoice Amount</label>
                                            <input type="number" value="{{ optional($cashier_stage)->invoice_amount }}"
                                                name="invoice_amount" id="invoice_amount" class="form-control"
                                                step="0.01" placeholder="0.00" min="0.00"
                                                onchange="validateAmount()">
                                            <input type="hidden" value="{{ optional($entry)->order_value }}"
                                                name="quote_amount" id="quote_amount" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Variance Explanation</label>
                                            <input type="text"
                                                value="{{ optional($cashier_stage)->variance_explanation }}"
                                                name="variance_explanation" id="variance_explanation" disabled
                                                class="form-control" onchange="validateAmount()">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Total Amount Paid</label>
                                            <input type="number" value="{{ optional($cashier_stage)->total_amount_paid }}"
                                                name="total_amount_paid" id="total_amount_paid" class="form-control"
                                                step="0.01" placeholder="0.00" min="0.00"
                                                onchange="validateAmountPaid()">
                                        </div>

                                        <div class="form-group col-md-6 required">
                                            <label>Invoice Status</label>
                                            <select name="invoice_status" id="invoice_status"
                                                class="form-control readonly-select">
                                                <option value="UNPAID"
                                                    {{ optional($cashier_stage)->invoice_status == 'UNPAID' ? 'selected' : '' }}>
                                                    UNPAID</option>
                                                <option value="Excess amount Advance Payment"
                                                    {{ optional($cashier_stage)->invoice_status == 'Excess amount Advance Payment' ? 'selected' : '' }}>
                                                    Excess amount Advance Payment
                                                </option>
                                                <option value="PAID"
                                                    {{ optional($cashier_stage)->invoice_status == 'PAID' ? 'selected' : '' }}>
                                                    PAID</option>
                                                <option value="PARTIALLY PAID"
                                                    {{ optional($cashier_stage)->invoice_status == 'PARTIALLY PAID' ? 'selected' : '' }}>
                                                    PARTIALLY PAID</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 required">
                                            <label>Balance to be Paid</label>
                                            <input type="number"
                                                value="{{ optional($cashier_stage)->balance_to_be_paid }}"
                                                name="balance_to_be_paid" id="balance_to_be_paid" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Select if Apllicable</label>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label><input type="checkbox"
                                                            value="{{ optional($cashier_stage)->special_authorization }}"
                                                            name="special_authorization" id="special_authorization"
                                                            onchange="specialAuthorizationTogleCashier()"> Special
                                                        authorization
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Special Instructions</label>
                                            <textarea name="special_instructions" id="special_instructions" oninput="controlInputData()" class="form-control"
                                                disabled>{{ optional($cashier_stage)->special_instructions }}</textarea>
                                        </div>

                                        <hr>

                                        <div class="form-group col-md-6 ">
                                            <div id="invoiceContainer"
                                                style="display: {{ isset($cashier_stage->invoice) ? 'none' : 'block' }}">
                                                <label>Invoice <span style="color: #e25b6a">*</span></label>
                                                <input type="file" name="invoice" id="invoice"
                                                    class="form-control">
                                            </div>

                                            <div class="existing-file"
                                                style="display: {{ isset($cashier_stage->invoice) ? 'block' : 'none' }}"
                                                id="fileDisplayInvoice">
                                                @if (isset($cashier_stage->invoice))
                                                    <a href="{{ Storage::url($cashier_stage->invoice) }}"
                                                        target="_blank">Download/View Invoice</a>
                                                    <button type="button"
                                                        onclick="removeFile('invoice', 'fileDisplayInvoice', 'invoiceContainer')"
                                                        class="file_clear_button btn btn-light btn-sm float-right"
                                                        title="Clear file"
                                                        data-filename="{{ $cashier_stage->invoice }}"><i
                                                            class="la la-remove"></i></button>
                                                    <div class="clearfix"></div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div id="receiptContainer"
                                                style="display: {{ isset($cashier_stage->receipt) ? 'none' : 'block' }}">
                                                <label>Receipt</label>
                                                <input type="file" name="receipt" id="receipt"
                                                    class="form-control">
                                            </div>

                                            <div class="existing-file"
                                                style="display: {{ isset($cashier_stage->receipt) ? 'block' : 'none' }}"
                                                id="fileDisplayReceipt">
                                                @if (isset($cashier_stage->receipt))
                                                    <a href="{{ Storage::url($cashier_stage->receipt) }}"
                                                        target="_blank">Download/View Receipt</a>
                                                    <button type="button"
                                                        onclick="removeFile('receipt', 'fileDisplayReceipt', 'receiptContainer')"
                                                        class="file_clear_button btn btn-light btn-sm float-right"
                                                        title="Clear file"
                                                        data-filename="{{ $cashier_stage->receipt }}"><i
                                                            class="la la-remove"></i></button>
                                                    <div class="clearfix"></div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div id="otherContainer"
                                                style="display: {{ isset($cashier_stage->other) ? 'none' : 'block' }}">
                                                <label>Other</label>
                                                <input type="file" name="other" id="other"
                                                    class="form-control">
                                            </div>

                                            <div class="existing-file"
                                                style="display: {{ isset($cashier_stage->other) ? 'block' : 'none' }}"
                                                id="fileDisplayOther">
                                                @if (isset($cashier_stage->other))
                                                    <a href="{{ Storage::url($cashier_stage->other) }}"
                                                        target="_blank">Download/View Other</a>
                                                    <button type="button"
                                                        onclick="removeFile('other', 'fileDisplayOther', 'otherContainer')"
                                                        class="file_clear_button btn btn-light btn-sm float-right"
                                                        title="Clear file" data-filename="{{ $cashier_stage->other }}"><i
                                                            class="la la-remove"></i></button>
                                                    <div class="clearfix"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-none" id="parentLoadedAssets">[]</div>
                                <div id="saveActions" class="form-group my-3">
                                    <input type="hidden" name="_save_action" value="submit_cashier_stage">
                                    <button type="submit" class="btn btn-success" id="submit_btn">
                                        <span class="la la-save" role="presentation"aria-hidden="true"></span> &nbsp;
                                        <span data-value="create_new_process">Submit</span>
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
