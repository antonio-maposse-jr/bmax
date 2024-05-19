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

    @foreach ($reason_declines as $reasonDecline)
        <div class="notification-bar" style="background-color: red;">
            <strong>Process declined </strong> by
            <strong>{{ $reasonDecline->user->name }}</strong>. The reason is <strong>{{ $reasonDecline->reason }}</strong>
            with
            the following description <strong>{{ $reasonDecline->comment }}</strong>

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


                    @if (isset($credit_control_stage) && isset($credit_control_stage->id))
                        <li role="presentation" class="nav-item">
                            <a href="#tab_credit_control" aria-controls="tab_credit_control" role="tab"
                                data-toggle="tab" tab_name="credit_control" data-name="credit_control" data-bs-toggle="tab"
                                class="nav-link text-decoration-none" aria-selected="false" tabindex="-1">Credit
                                Control</a>
                        </li>
                    @endif

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

                    @if (isset($authorisation_stage) && isset($authorisation_stage->id))
                        {{-- Authorisation Stage Data --}}
                        @include('admin.tabs.tab_authorisation')
                        {{-- End of Authorisation Stage Data --}}
                    @endif

                    {{-- Production Stage data --}}
                    @include('admin.tabs.tab_production')
                    {{-- End of Production Stage data --}}


                    @if (isset($credit_control_stage) && isset($credit_control_stage->id))
                        {{-- Credit Control Stage Data --}}
                        @include('admin.tabs.tab_credit_control')
                        {{-- End of Credit Control Data --}}
                    @endif

                    {{-- Dispatch Stage form --}}
                    @include('admin.tabs.tab_dispatch')
                    {{-- End of Dispatch Stage form --}}

                </div>
            </div>
        </div>


    @endsection
