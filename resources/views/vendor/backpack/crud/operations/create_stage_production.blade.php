@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Stage Production' => url('') . '/admin/stage-production',
        'Add Stage Production' => false,
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
                            class="nav-link text-decoration-none active" aria-selected="true">Process Summary</a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#tab_cashier" aria-controls="tab_cashier" role="tab" data-toggle="tab"
                            tab_name="cashier" data-name="cashier" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Cashier</a>
                    </li>
                    @if (isset($authorisation_stage) && isset($authorisation_stage->id))
                        <li role="presentation" class="nav-item">
                            <a href="#tab_authorisation" aria-controls="tab_authorisation" role="tab" data-toggle="tab"
                                tab_name="authorisation" data-name="authorisation" data-bs-toggle="tab"
                                class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Authorisation</a>
                        </li>
                    @endif

                    <li role="presentation" class="nav-item">
                        <a href="#tab_production" aria-controls="tab_production" role="tab" data-toggle="tab"
                            tab_name="production" data-name="production" data-bs-toggle="tab"
                            class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Production</a>
                    </li>

                </ul>

                <div class="tab-content ">
                    {{-- Process Resume --}}
                    @include('admin.tabs.tab_process')
                    {{-- End of process Resume --}}

                    {{-- Cashier Stage Data --}}
                    @include('admin.tabs.tab_cashier')
                    {{-- End of Cashier Stage Data --}}

                    @if (isset($authorisation_stage) && isset($authorisation_stage->id))
                        {{-- Authorisation Stage Data --}}
                        @include('admin.tabs.tab_authorisation')
                        {{-- End of Authorisation Stage Data --}}
                    @endif

                    {{-- Production Stage form --}}
                    <div role="tabpanel" class="tab-pane" id="tab_production">
                        @if (Auth::user()->can('stage_productions_create'))
                            <div class="card">
                                <div class="card-body row">
                                    <table id="taskTable" class="table">
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
                                                data-total_allocated_panels="{{ $task->total_allocated_panels }}">
                                                <td>{{ $task->sub_task_name }}</td>
                                                <td>{{ $task->total_allocated_sheets }}</td>
                                                <td>{{ $task->total_allocated_panels }}</td>
                                                <td>{{ $task->total_work_time }}</td>
                                                <td>{{ $task->total_iddle_time }}</td>
                                                <td>
                                                    @switch($task->task_status)
                                                        @case('PROCESSING')
                                                            <span
                                                                class="badge badge-pill badge-info">{{ $task->task_status }}</span>
                                                        @break

                                                        @case('PENDING')
                                                            <span
                                                                class="badge badge-pill badge-warning">{{ $task->task_status }}</span>
                                                        @break

                                                        @case('PAUSED')
                                                            <span
                                                                class="badge badge-pill badge-danger">{{ $task->task_status }}</span>
                                                        @break

                                                        @case('COMPLETED')
                                                            <span
                                                                class="badge badge-pill badge-success">{{ $task->task_status }}</span>
                                                        @break

                                                        @default
                                                            <!-- Default case if none of the above conditions are met -->
                                                    @endswitch

                                                <td>
                                                    @php
                                                        $commonAttributes = 'onclick="openConfirmationPopup(this)"';
                                                        $disabledAttribute = 'disabled';
                                                    @endphp

                                                    <button type="submit" class="btn btn-outline-info btn-sm"
                                                        @if ($task->task_name == 'cutting') onclick="openPopupSheets(this)"
                                                    @elseif($task->task_name == 'edging')
                                                    onclick="openPopupPanels(this)" 
                                                    @else
                                                    onclick="openConfirmationPopup(this, 'PROCESSING')" @endif
                                                        {!! $task->task_status == 'PENDING' || $task->task_status == 'PAUSED' ? '' : $disabledAttribute !!}>
                                                        Assign
                                                    </button>

                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        {!! 'onclick=\'openConfirmationPopup(this, "PAUSED")\'' !!} {!! $task->task_status == 'PROCESSING' ? '' : $disabledAttribute !!}>
                                                        Hold
                                                    </button>

                                                    <button type="submit" class="btn btn-outline-success btn-sm"
                                                        {!! 'onclick=\'openConfirmationPopup(this, "COMPLETED")\'' !!} {!! $task->task_status == 'PROCESSING' ? '' : $disabledAttribute !!}>
                                                        Completed
                                                    </button>

                                                    @if ($task->task_name == 'cutting')
                                                        <button type="submit" class="btn btn-outline-warning btn-sm"
                                                            {!! 'onclick=\'openPopupSheets(this, "edit")\'' !!} {!! $task->task_status == 'PROCESSING' || $task->task_status == 'PAUSED' ? '' : $disabledAttribute !!}>
                                                            Edit
                                                        </button>
                                                    @endif
                                                    @if ($task->task_name == 'edging')
                                                        <button type="submit" class="btn btn-outline-warning btn-sm"
                                                            {!! 'onclick=\'openPopupPanels(this, "edit")\'' !!} {!! $task->task_status == 'PROCESSING' || $task->task_status == 'PAUSED' ? '' : $disabledAttribute !!}>
                                                            Edit
                                                        </button>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach

                                    </table>
                             
                                    <form method="post" action="{{ route('submit-stage-production-data') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group col-md-6 required">
                                            <div id="otherContainer"
                                                style="display: {{ isset($production_stage->other) ? 'none' : 'block' }}">
                                                <label>Other Document </label>
                                                <input type="hidden" name="process_id" value="{{ $entry->id }}">
                                                <input type="file" name="other" id="other"
                                                    class="form-control">
                                            </div>

                                            <div class="existing-file"
                                                style="display: {{ isset($production_stage->other) ? 'block' : 'none' }}"
                                                id="fileDisplayOther">
                                                @if (isset($production_stage->other))
                                                    <a href="{{ Storage::url($production_stage->other) }}"
                                                        target="_blank">Download/View Other</a>
                                                    <button type="button"
                                                        onclick="removeFile('other', 'fileDisplayOther', 'otherContainer')"
                                                        class="file_clear_button btn btn-light btn-sm float-right"
                                                        title="Clear file"
                                                        data-filename="{{ $production_stage->other }}"><i
                                                            class="la la-remove"></i></button>
                                                    <div class="clearfix"></div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-none" id="parentLoadedAssets">[]</div>
                                        <div id="saveActions" class="form-group my-3">
                                            <input type="hidden" name="_save_action" value="submit_cashier_stage">
                                            <button type="submit" class="btn btn-success" id="submit_btn" disabled>
                                                <span class="la la-save" role="presentation"aria-hidden="true"></span>
                                                &nbsp;
                                                <span data-value="create_new_process">Submit</span>
                                            </button>
                                            <button type="button" onclick="openPopup()" class="btn btn-info">
                                                <span class="la la-sync-alt" role="presentation"
                                                    aria-hidden="true"></span>
                                                &nbsp;
                                                <span data-value="create_new_process">Return stages</span>
                                            </button>

                                            <button type="button" onclick="openPopupDecline()" class="btn btn-danger">
                                                <span class="la la-window-close" role="presentation"
                                                    aria-hidden="true"></span>
                                                &nbsp;
                                                <span data-value="create_new_process">Decline Process</span>
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
                        @else
                            @include('admin.tabs.tab_unauthorized')
                        @endif
                    </div>
                    {{-- End of Production Stage form --}}

                </div>
            </div>
        </div>

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
            <h2 style="color: #333; text-align: center;" id="popup_sheet_title">Assign Sheets</h2>
            <form action="{{ route('assign-prod-task') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}">
                <input type="hidden" name="task_id" id="popup_task_id">
                <input type="hidden" name="task_name" id="popup_task_name">
                <input type="hidden" name="sub_task_name" id="popup_sub_task_name">

                <input type="hidden" name="option" id="popup_option">
                <input type="hidden" id="initial_allocated_sheets_task">
                <input type="hidden" name="total_sheets" value="{{ $entry->nr_sheets }}" id="total_sheets">

                <input type="hidden" name="total_unallocated_sheets"
                    value="{{ $production_stage->total_unallocated_sheets }}" id="initial_unallocated_sheets">



                <label class="popup_label">Total Sheets:</label>
                <input type="text" value="{{ $entry->nr_sheets }}" readonly class="popup_input">

                <label for="nr_sheets_unallocated" class="popup_label">Nr of Sheets unllocated:</label>
                <input type="text" readonly class="popup_input" id="nr_sheets_unallocated"
                    name="nr_sheets_unallocated" required>

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
            <h2 style="color: #333; text-align: center;" id="popup_panel_title">Assign Panels</h2>
            <form action="{{ route('assign-prod-panels') }}" method="post">
                @csrf
                <input type="hidden" name="process_id" value=" {{ $entry->id }}" class="form-control" readonly>
                <input type="hidden" name="task_id" id="panel_task_id">
                <input type="hidden" name="task_name" id="panel_task_name">
                <input type="hidden" name="sub_task_name" id="panel_sub_task_name">

                <input type="hidden" id="popup_option_panels">
                <input type="hidden" id="initial_allocated_panels_task">
                <input type="hidden" name="total_panels" value="{{ $entry->nr_panels }}" id="total_panels">

                <input type="hidden" name="total_unallocated_panels"
                    value="{{ $production_stage->total_unallocated_panels }}" id="initial_unallocated_panels">

                <label class="popup_label">Total Panels:</label>
                <input type="text" value="{{ $entry->nr_panels }}" readonly class="popup_input">

                <label for="nr_panels_unallocated" class="popup_label">Nr of Panels unllocated:</label>
                <input type="text" value="{{ $production_stage->total_unallocated_panels }}" readonly
                    class="popup_input" id="nr_panels_unallocated" name="nr_panels_unallocated" required>

                <label for="nr_sheets_allocated" class="popup_label">Nr of Panels to allocate:</label>
                <input type="text" class="popup_input" id="nr_panels_allocated" name="nr_panels_allocated"
                    oninput="checkPanelsAllocation()" required>

                <button type="submit" id="submit_panel_task" disabled class="btn btn-success">
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
