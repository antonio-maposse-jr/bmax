@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Stage Cashiers' => url('') . '/admin/customer',
        'Add Stage Cashier' => false,
    ];
    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Customers</h1>
        <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Preview customer.</p>

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
    <div class="nav-tabs-custom " id="customer_tabs">
        <ul class="nav nav-tabs " role="tablist">
            <li role="presentation" class="nav-item">
                <a href="#tab_customer" aria-controls="tab_customer" role="tab" data-toggle="tab" tab_name="customer"
                    data-name="customer" data-bs-toggle="tab" class="nav-link text-decoration-none active"
                    aria-selected="true">Customer</a>
            </li>
            <li role="presentation" class="nav-item">
                <a href="#tab_documents" aria-controls="tab_documents" role="tab" data-toggle="tab" tab_name="documents"
                    data-name="documents" data-bs-toggle="tab" class="nav-link text-decoration-none" aria-selected="false"
                    tabindex="-1">Documents</a>
            </li>
            <li role="presentation" class="nav-item">
                <a href="#tab_notifications" aria-controls="tab_notifications" role="tab" data-toggle="tab"
                    tab_name="notifications" data-name="notifications" data-bs-toggle="tab"
                    class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Notifications</a>
            </li>
        </ul>
        <div class="tab-content ">
            <div role="tabpanel" class="tab-pane active show" id="tab_customer">
                <div class="row" bp-section="crud-operation-show">
                    <div class="col-md-12">
                        <div class="">
                            <div class="card no-padding no-border mb-0">
                                <table class="table table-striped m-0 p-0">
                                    <tbody>
                                        <tr>
                                            <td class="border-top-0">
                                                <strong>Customer category:</strong>
                                            </td>
                                            <td class="border-top-0">
                                                <span>
                                                    {{ $entry->customerCategory->name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Name:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Id type:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->id_type }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Id number:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->id_number }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Email:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    <a href="mailto:{{ $entry->email }}"> {{ $entry->email }}
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Phone:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->phone }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Address:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->address }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Tax number:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->tax_number }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Contact person name:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->contact_person_name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Contact person phone:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->contact_person_phone }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Contact person email:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    {{ $entry->contact_person_email }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Id document:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    @if (isset($entry->id_document))
                                                        <a href="{{ Storage::url($entry->id_document) }}"
                                                            target="_blank">Download/View Quote</a>
                                                    @else
                                                        <p>No documents available</p>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Company reg document:</strong>
                                            </td>
                                            <td>
                                                <span>
                                                    @if (isset($entry->company_reg_document))
                                                        <a href="{{ Storage::url($entry->company_reg_document) }}"
                                                            target="_blank">Download/View Quote</a>
                                                    @else
                                                        <p>No documents available</p>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Created:</strong>
                                            </td>
                                            <td>
                                                <span data-order="2024-02-17 06:31:26">
                                                    {{ $entry->created_at }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Updated:</strong>
                                            </td>
                                            <td>
                                                <span data-order="2024-02-27 12:30:45">
                                                    {{ $entry->updated_at }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Actions</strong>
                                            </td>
                                            <td>
                                                <a href="{{ url('') }}/admin/customer/{{ $entry->id }}/edit"
                                                    class="btn btn-sm btn-link">
                                                    <span><i class="la la-edit"></i> Edit</span>
                                                </a>

                                                <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                                    data-route="{{ url('') }}/admin/customer/{{ $entry->id }}"
                                                    class="btn btn-sm btn-link" data-button-type="delete">
                                                    <span><i class="la la-trash"></i> Delete</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab_documents">
                <div class="col-md-12">
                    <div class="">
                        <div class="card no-padding no-border mb-0">
                            <table class="table table-striped m-0 p-0">
                                <tbody>
                                    @if ($entry->has('processes'))
                                        @foreach ($entry->processes as $item)
                                            <tr>
                                                <td>
                                                    <strong>Job layout #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        @if (isset($item->job_layout))
                                                            <a href="{{ Storage::url($item->job_layout) }}"
                                                                target="_blank">Download/View Job Layout</a>
                                                        @else
                                                            <p>No documents available</p>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Cutting list #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        <span>
                                                            @if (isset($item->cutting_list))
                                                                <a href="{{ Storage::url($item->cutting_list) }}"
                                                                    target="_blank">Download/View Cutting list</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif
                                                        </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Quote #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        <span>
                                                            @if (isset($item->quote))
                                                                <a href="{{ Storage::url($item->quote) }}"
                                                                    target="_blank">Download/View Quote</a>
                                                            @else
                                                                <p>No documents available</p>
                                                            @endif

                                                        </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Confirmation call record #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        <span>
                                                            @if (isset($item->confirmation_call_record))
                                                                <a href="{{ Storage::url($item->confirmation_call_record) }}"
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
                                                    <strong>Signed confirmation #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        @if (isset($item->signed_confirmation))
                                                            <a href="{{ Storage::url($item->signed_confirmation) }}"
                                                                target="_blank">Download/View Signed confirmation</a>
                                                        @else
                                                            <p>No documents available</p>
                                                        @endif

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Custom cutting list #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        @if (isset($item->custom_cutting_list))
                                                            <a href="{{ Storage::url($item->custom_cutting_list) }}"
                                                                target="_blank">Download/View Custom cutting list</a>
                                                        @else
                                                            <p>No documents available</p>
                                                        @endif

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Other document #{{ $item->id }}:</strong>
                                                </td>
                                                <td>
                                                    <span>
                                                        @if (isset($item->other_document))
                                                            <a href="{{ Storage::url($item->other_document) }}"
                                                                target="_blank">Download/View Other document</a>
                                                        @else
                                                            <p>No documents available</p>
                                                        @endif

                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>No related items found.</p>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab_notifications">
                <div class="card">
                    <div class="card-body row">

                        <div class="form-group col-md-12 required">
                            <div class="row">
                                @if ($entry->has('notifications'))
                                    @foreach ($entry->notifications as $notification)
                                        <label><input type="checkbox" value="{{ $notification->id }}" checked disabled>
                                            {{ $notification->systemNotification->name }} </label>
                                    @endforeach
                                    <td>
                                        <a href="{{ url('') }}/admin/customer/{{ $entry->id }}/notifications"
                                            class="btn btn-sm btn-link">
                                            <span><i class="la la-bell"></i> Manage Notifications</span>
                                        </a>
                                    </td>
                                @else
                                    <p>No notifications found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
