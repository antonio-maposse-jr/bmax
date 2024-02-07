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
        <h1 class="text-capitalize mb-0" bp-section="page-heading">stage production</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Add stage production.</p>

        <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
            <small>
                <a href="{{ url('') }}/admin/stage-production" class="d-print-none font-sm">
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
                                                        <span>
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
                                                        <strong>Colors:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $entry->colors }}
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
                                                            {{ $cashier_stage->id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Process ID:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->process_id }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Invoice reference:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->invoice_reference }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Invoice amount:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->invoice_amount }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Variance explanation:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->variance_explanation }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Reciept reference:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->reciept_reference }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Total amount paid:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->total_amount_paid }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Invoice status:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->invoice_status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Balance to be paid:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->balance_to_be_paid }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Special authorization:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->special_authorization == 1 ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Special instructions:</strong>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            {{ $cashier_stage->special_instructions }}
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
                                                            {{ $cashier_stage->user->name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <td>
                                                    <strong>Created:</strong>
                                                </td>
                                                <td>
                                                    <span data-order="{{ $cashier_stage->created_at }}">
                                                        {{ $cashier_stage->created_at }}
                                                    </span>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Updated:</strong>
                                                    </td>
                                                    <td>
                                                        <span data-order=" {{ $cashier_stage->updated_at }}">
                                                            {{ $cashier_stage->updated_at }}
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

                    {{-- Production Stage form --}}
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
                                        <th>Actions</th>
                                    </tr>
                                    @foreach ($production_tasks as $task)
                                        <tr data-task_id="{{ $task->id }}" data-task_name="{{ $task->task_name }}"
                                            data-sub_task_name="{{ $task->sub_task_name }}" 
                                            data-total_allocated_sheets="{{ $task->total_allocated_sheets }}"
                                            data-total_allocated_panels="{{ $task->total_allocated_panels }}"
                                            >
                                            <td>{{ $task->sub_task_name }}</td>
                                            <td>{{ $task->total_allocated_sheets }}</td>
                                            <td>{{ $task->total_allocated_panels }}</td>
                                            <td>{{ $task->total_work_time }}</td>
                                            <td>{{ $task->total_iddle_time }}</td>
                                            <td>{{ $task->task_status }}</td>
                                            <td>
                                                @php
                                                    $commonAttributes = 'onclick="openConfirmationPopup(this)"';
                                                    $disabledAttribute = 'disabled';
                                                @endphp

                                                <button type="submit" class="btn btn-info"
                                                    @if ($task->task_name == 'cutting') onclick="openPopupSheets(this)"
                                                    @elseif($task->task_name == 'edging')
                                                    onclick="openPopupPanels(this)" 
                                                    @else
                                                    onclick="openConfirmationPopup(this, 'PROCESSING')" 
                                                    @endif
                                                    {!! ($task->task_status == 'PENDING' || $task->task_status == 'PAUSED') ? '' : $disabledAttribute !!}>
                                                    Assign
                                                </button>

                                                <button type="submit" class="btn btn-danger" {!! 'onclick=\'openConfirmationPopup(this, "PAUSED")\'' !!}
                                                    {!! ( $task->task_status == 'PROCESSING') ? '' : $disabledAttribute !!}>
                                                    Hold
                                                </button>

                                                <button type="submit" class="btn btn-success" {!! 'onclick=\'openConfirmationPopup(this, "COMPLETED")\'' !!}
                                                    {!! $task->task_status == 'PROCESSING' ? '' : $disabledAttribute !!}>
                                                    Completed
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </table>
                                <hr>
                                <form method="post" action="{{ route('submit-stage-production-data') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                              

                                    <div class="form-group col-md-6 required">
                                        <div id="otherContainer" style="display: {{ isset($production_stage->other) ? 'none' : 'block' }}">
                                            <label>Other Document </label>
                                            <input type="hidden" name="process_id" value="{{ $entry->id }}">
                                            <input type="file" name="other" id="other" class="form-control">
                                        </div>
                                    
                                        <div class="existing-file" style="display: {{ isset($production_stage->other) ? 'block' : 'none' }}" id="fileDisplayOther">
                                            @if(isset($production_stage->other))
                                                <a href="{{ Storage::url($production_stage->other) }}" target="_blank">Download/View Other</a>
                                                <button type="button" onclick="removeFile('other', 'fileDisplayOther', 'otherContainer')" class="file_clear_button btn btn-light btn-sm float-right" title="Clear file" data-filename="{{ $production_stage->other }}"><i class="la la-remove"></i></button>
                                                <div class="clearfix"></div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-none" id="parentLoadedAssets">[]</div>
                                    <div id="saveActions" class="form-group my-3">
                                        <input type="hidden" name="_save_action" value="submit_cashier_stage">
                                        <button type="submit" class="btn btn-success" id="submit_btn" disabled>
                                            <span class="la la-save" role="presentation"aria-hidden="true"></span> &nbsp;
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

                            </div>

                        </div>

                    </div>
                    {{-- End of Production Stage form --}}

                </div>
            </div>
        </div>

        {{-- Decline popup --}}
        <div class="popup_sheets" id="popup_decline">
            <div class="close-btn_rs" onclick="closePopupPanels()">X</div>
            <h2 style="color: #333; text-align: center;">Decline process</h2>
            <form action="{{ route('assign-prod-panels') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}" class="form-control" readonly>
                

                <label for="nr_sheets_unallocated" class="popup_label">Nr of Panels unllocated:</label>
                <input type="text" value="{{ $production_stage->total_unallocated_panels }}" readonly
                    class="popup_input" id="nr_panels_unallocated" name="nr_panels_unallocated" required>

                <label for="nr_sheets_allocated" class="popup_label">Nr of Panels to allocate:</label>
                <input type="text" class="popup_input" id="nr_panels_allocated" name="nr_panels_allocated"
                    oninput="checkPanelsAllocation()" required>

                <button type="submit" id="submit_panel_task_btn" disabled class="btn btn-success">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="create_new_process">Submit</span>
                </button>
            </form>
        </div>
        {{-- End Decline popup --}}
        {{-- Return to Stage popup --}}
        <div class="overlay_rs" id="overlay_rs" onclick="closePopup()"></div>
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
                    <option value="1">Sales Stage</option>
                    <option value="2">Cashier Stage</option>
                    <option value="3">Authorization Stage</option>
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
        {{-- End return to stage popup --}}

        {{-- Assign Sheets --}}
        <div class="popup_sheets" id="popup_sheets">
            <div class="close-btn_rs" onclick="closePopupSheets()">X</div>
            <h2 style="color: #333; text-align: center;">Assign Sheets</h2>
            <form action="{{ route('assign-prod-task') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}">
                <input type="hidden" name="task_id" id="popup_task_id">
                <input type="hidden" name="task_name" id="popup_task_name">
                <input type="hidden" name="sub_task_name" id="popup_sub_task_name">
                <input type="hidden" name="initial_allocation_sheets" id="initial_allocation_sheets">

                <input type="hidden" name="total_unallocated_sheets" value="{{ $production_stage->total_unallocated_sheets }}" id="popup_unallocated_sheets">
               
                <label for="nr_sheets_unallocated" class="popup_label">Nr of Sheets unllocated:</label>
                <input type="text" value="{{ $production_stage->total_unallocated_sheets }}" readonly 
                    class="popup_input" id="nr_sheets_unallocated" name="nr_sheets_unallocated" required>

                <label for="nr_sheets_allocated" class="popup_label">Nr of Sheets to allocate:</label>
                <input type="text" class="popup_input" id="nr_sheets_allocated" name="nr_sheets_allocated"
                    oninput="checkSheetAllocation()" required>

                <button type="submit" id="submit_sheet_task_btn" disabled class="btn btn-success">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="create_new_process">Submit</span>
                </button>
            </form>
        </div>
        {{-- End of Assign Sheets --}}

        {{-- Assign Panels --}}
        <div class="popup_sheets" id="popup_panels">
            <div class="close-btn_rs" onclick="closePopupPanels()">X</div>
            <h2 style="color: #333; text-align: center;">Assign Panels</h2>
            <form action="{{ route('assign-prod-panels') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}" class="form-control" readonly>
                <input type="hidden" name="task_id" id="panel_task_id">
                <input type="hidden" name="task_name" id="panel_task_name">
                <input type="hidden" name="sub_task_name" id="panel_sub_task_name">

                <input type="hidden" name="initial_allocation_panels" id="initial_allocation_panels">

                <input type="hidden" name="total_unallocated_panels" value="{{ $production_stage->total_unallocated_panels }}" id="popup_unallocated_panels">
               

                <label for="nr_sheets_unallocated" class="popup_label">Nr of Panels unllocated:</label>
                <input type="text" value="{{ $production_stage->total_unallocated_panels }}" readonly
                    class="popup_input" id="nr_panels_unallocated" name="nr_panels_unallocated" required>

                <label for="nr_sheets_allocated" class="popup_label">Nr of Panels to allocate:</label>
                <input type="text" class="popup_input" id="nr_panels_allocated" name="nr_panels_allocated"
                    oninput="checkPanelsAllocation()" required>

                <button type="submit" id="submit_panel_task_btn" disabled class="btn btn-success">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="create_new_process">Submit</span>
                </button>
            </form>
        </div>
        {{-- End of Assign Sheets --}}

        <div class="overlay" id="overlay" onclick="closeConfirmationPopup()"></div>
        <div class="popup-container-task" id="confirmationPopup" style="display:none;">
            <span class="close-btn" onclick="closeConfirmationPopup()">X</span>
            <p id="popupContent"></p>
            <form action="{{ route('submit-prod-task') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}" class="form-control" readonly>

                <input type="hidden" name="task_id" id="confirm_task_id">
                <input type="hidden" name="task_status" id="confirm_task_status">
                <input type="hidden" name="task_name" id="confirm_task_name">
                <input type="hidden" name="sub_task_name" id="confirm_sub_task_name">

                <button type="submit" class="btn btn-success">Yes</button>
                <button type="button" class="btn" onclick="cancelAction()">No</button>
            </form>

        </div>



    @endsection
