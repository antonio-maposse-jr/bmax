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
                            class="nav-link text-decoration-none active" aria-selected="true">Process Resume</a>
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
                    <div role="tabpanel" class="tab-pane active show" id="tab_process">
                        <div class="row" bp-section="crud-operation-show">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card no-padding no-border mb-0">
                                        <table class="table table-striped m-0 p-0">
                                            <tbody>
                                                <tr>
                                                    <td class="border-top-0">
                                                        <strong>Nr sheets:</strong>
                                                    </td>
                                                    <td class="border-top-0">
                                                        <span>
                                                            {{ $entry->nr_sheets }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Nr panels:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->nr_panels }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Order value:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->order_value }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Estimated process time:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->estimated_process_time }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Date required:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order="2024-01-12">
                                                            {{ $entry->date_required }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Priority level:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->priority_level }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Job reference:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->job_reference }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Order confirmation:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->order_confirmation }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Key Products:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->products->pluck('product.name')->implode(', ') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Status:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Stage Id:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->stage_id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Stage Name:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->stage_name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Job layout:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($entry->job_layout))
                                                                <a href="{{ Storage::url($entry->job_layout) }}"
                                                                    target="_blank">Download/View Job Layout</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Cutting list:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <span>
                                                                @if (isset($entry->cutting_list))
                                                                    <a href="{{ Storage::url($entry->cutting_list) }}"
                                                                        target="_blank">Download/View Cutting list</a>
                                                                @else
                                                                    <p>No documents available</p>
                                                                @endif
                                                            </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Quote:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <span>
                                                                @if (isset($entry->quote))
                                                                    <a href="{{ Storage::url($entry->quote) }}"
                                                                        target="_blank">Download/View Quote</a>
                                                                @else
                                                                    <p>No documents available</p>
                                                                @endif

                                                            </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Confirmation call record:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <span>
                                                                @if (isset($entry->confirmation_call_record))
                                                                    <a href="{{ Storage::url($entry->confirmation_call_record) }}"
                                                                        target="_blank">Download/View Confirmation call
                                                                        record</a>
                                                                @else
                                                                    <p>No documents available</p>
                                                                @endif
                                                            </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Signed confirmation:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($entry->signed_confirmation))
                                                                <a href="{{ Storage::url($entry->signed_confirmation) }}"
                                                                    target="_blank">Download/View Signed confirmation</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif

                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Custom cutting list:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($entry->custom_cutting_list))
                                                                <a href="{{ Storage::url($entry->custom_cutting_list) }}"
                                                                    target="_blank">Download/View Custom cutting list</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif

                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Other document:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($entry->other_document))
                                                                <a href="{{ Storage::url($entry->other_document) }}"
                                                                    target="_blank">Download/View Other document</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif

                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Cutting:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->cutting == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Edging:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->edging == 1 ? 'Yes' : 'No' }}

                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Cnc machining:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->cnc_machining == 1 ? 'Yes' : 'No' }}

                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Grooving:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->grooving == 1 ? 'Yes' : 'No' }}

                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Hinge boring:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->hinge_boring == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Wrapping:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->wrapping == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Sanding:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->sanding == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Hardware:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->hardware == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>User Submited:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->user->name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Created:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order="{{ $entry->created_at }}">
                                                            {{ $entry->created_at }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Updated:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order=" {{ $entry->updated_at }}">
                                                            {{ $entry->updated_at }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of process Resume --}}

                    {{-- Cashier Stage Data --}}
                    <div role="tabpanel" class="tab-pane" id="tab_cashier">
                        <div class="row" bp-section="crud-operation-show">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card no-padding no-border mb-0">
                                        <table class="table table-striped m-0 p-0">
                                            <tbody>
                                                <tr>
                                                    <td class="border-top-0">
                                                        <strong>ID:</strong>
                                                    </td>
                                                    <td class="border-top-0">
                                                        <span>
                                                            {{ optional($cashier_stage)->id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Process ID:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->process_id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Invoice reference:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->invoice_reference }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Invoice amount:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->invoice_amount }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Variance explanation:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->variance_explanation }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Reciept reference:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->reciept_reference }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Total amount paid:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->total_amount_paid }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Invoice status:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->invoice_status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Balance to be paid:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->balance_to_be_paid }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Special authorization:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->special_authorization == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Special instructions:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->special_instructions }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Invoice:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <span>
                                                                @if (isset($cashier_stage->invoice))
                                                                    <a href="{{ Storage::url($cashier_stage->invoice) }}"
                                                                        target="_blank">Download/View Other Invoice</a>
                                                                @else
                                                                    <p>No documents available</p>
                                                                @endif
                                                            </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Receipt:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($cashier_stage->receipt))
                                                                <a href="{{ Storage::url($cashier_stage->receipt) }}"
                                                                    target="_blank">Download/View Other Receipt</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Other Documents:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($cashier_stage->other))
                                                                <a href="{{ Storage::url($cashier_stage->other) }}"
                                                                    target="_blank">Download/View Other Documents</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>User processed:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($cashier_stage)->user ? optional($cashier_stage)->user->name : '' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <td>
                                                    <strong>Created:</strong>
                                                </td>
                                                <td>
                                                    <span data-order="{{ optional($cashier_stage)->created_at }}">
                                                        {{ optional($cashier_stage)->created_at }}
                                                    </span>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Updated:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order=" {{ optional($cashier_stage)->updated_at }}">
                                                            {{ optional($cashier_stage)->updated_at }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of Cashier Stage Data --}}

                    {{-- Authorisation Stage Data --}}
                    <div role="tabpanel" class="tab-pane" id="tab_authorisation">
                        <div class="row" bp-section="crud-operation-show">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card no-padding no-border mb-0">
                                        <table class="table table-striped m-0 p-0">
                                            <tbody>
                                                <tr>
                                                    <td class="border-top-0">
                                                        <strong>ID:</strong>
                                                    </td>
                                                    <td class="border-top-0">
                                                        <span>
                                                            {{ optional($authorisation_stage)->id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Process ID:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($authorisation_stage)->process_id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Comment:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($authorisation_stage)->comment }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Decision:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($authorisation_stage)->decision }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Comments:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($authorisation_stage)->comments }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Special conditions:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($authorisation_stage)->special_conditions == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Other documents:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($authorisation_stage->other_documents))
                                                                <a href="{{ Storage::url($authorisation_stage->other_documents) }}"
                                                                    target="_blank">Download/View Other Documents</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>User processed:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($authorisation_stage)->user ? optional($authorisation_stage)->user->name : '' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Created:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order="{{ optional($cashier_stage)->created_at }}">
                                                            {{ optional($cashier_stage)->created_at }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Updated:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order=" {{ optional($cashier_stage)->updated_at }}">
                                                            {{ optional($cashier_stage)->updated_at }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of Authorisation Stage Data --}}

                    {{-- Production Stage data --}}
                    <div role="tabpanel" class="tab-pane" id="tab_production">
                        <div class="card">
                            <div class="card-body row">
                                <table id="taskTable">
                                    <tr>
                                        <th>Task</th>
                                        <th>Sheets Alocated</th>
                                        <th>Panels Alocated</th>
                                        <th>Total Work (Min)</th>
                                        <th>Total Iddle Time (Min)</th>
                                        <th>Task Status</th>
                                    </tr>
                                    @foreach ($production_tasks as $task)
                                        <tr data-task_id="{{ $task->id }}" data-task_name="{{ $task->task_name }}"
                                            data-sub_task_name="{{ $task->sub_task_name }}">
                                            <td>{{ $task->sub_task_name }}</td>
                                            <td>{{ $task->total_allocated_sheets }}</td>
                                            <td>{{ $task->total_allocated_panels }}</td>
                                            <td>{{ $task->total_work_time }}</td>
                                            <td>{{ $task->total_iddle_time }}</td>
                                            <td>{{ $task->task_status }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                                <hr>
                                <span>
                                    @if (isset($production_stage->other))
                                        <a href="{{ Storage::url($production_stage->other) }}"
                                            target="_blank">Download/View Other Documents</a>
                                    @else
                                        <p>No documents available</p>
                                    @endif
                                </span>
                     
                            </div>

                        </div>

                    </div>
                    {{-- End of Production Stage data --}}

                    {{-- Credit Control Stage Data --}}
                    <div role="tabpanel" class="tab-pane" id="tab_credit_control">
                        <div class="row" bp-section="crud-operation-show">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card no-padding no-border mb-0">
                                        <table class="table table-striped m-0 p-0">
                                            <tbody>
                                                <tr>
                                                    <td class="border-top-0">
                                                        <strong>ID:</strong>
                                                    </td>
                                                    <td class="border-top-0">
                                                        <span>
                                                            {{ optional($credit_control_stage)->id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Process ID:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($credit_control_stage)->process_id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Comment:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($credit_control_stage)->comment }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Decision:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($credit_control_stage)->decision }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Comments:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($credit_control_stage)->comments }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Special conditions:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($credit_control_stage)->special_conditions == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Other documents:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            @if (isset($credit_control_stage->other_documents))
                                                                <a href="{{ Storage::url($credit_control_stage->other_documents) }}"
                                                                    target="_blank">Download/View Other Documents</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>User processed:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($credit_control_stage)->user ? optional($credit_control_stage)->user->name : '' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Created:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order="{{ optional($credit_control_stage)->created_at }}">
                                                            {{ optional($credit_control_stage)->created_at }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Updated:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order=" {{ optional($credit_control_stage)->updated_at }}">
                                                            {{ optional($credit_control_stage)->updated_at }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of Credit Control Data --}}

                    {{-- Dispatch Stage form --}}
                    <div role="tabpanel" class="tab-pane" id="tab_dispatch">
                        <div class="row" bp-section="crud-operation-show">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="card no-padding no-border mb-0">
                                        <table class="table table-striped m-0 p-0">
                                            <tbody>
                                                <tr>
                                                    <td class="border-top-0">
                                                        <strong>ID:</strong>
                                                    </td>
                                                    <td class="border-top-0">
                                                        <span>
                                                            {{ optional($dispatch_stage)->id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Process ID:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($dispatch_stage)->process_id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Comment:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($dispatch_stage)->comment }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Status:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($dispatch_stage)->dispatch_status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Number of Panels:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($dispatch_stage)->nr_panels }}
                                                        </span>
                                                    </td>
                                                </tr>
                                   
                                                <tr>
                                                    <td>
                                                        <strong>User processed:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ optional($dispatch_stage)->user ? optional($dispatch_stage)->user->name : '' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Created:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order="{{ optional($dispatch_stage)->created_at }}">
                                                            {{ optional($dispatch_stage)->created_at }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Updated:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order=" {{ optional($dispatch_stage)->updated_at }}">
                                                            {{ optional($dispatch_stage)->updated_at }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End of Dispatch Stage form --}}

                </div>
            </div>
        </div>


    @endsection
